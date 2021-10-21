<template>
    <v-card>
        <v-card-text>
            <v-data-table :items="items"
                          :headers="headers"
                          item-key="id"
                          :loading="loading"
                          loading-text="Hämtar produkter..."
                          :dense="!($vuetify.breakpoint.mobile)"
                          :items-per-page="-1"
                          group-by="category_name"
                          :single-expand="true"
                          show-expand
                          :search="search"
                          @click:row="expandRow"
                          :expanded="expanded"
                          sort-by="name"
                          must-sort
            >
              <template v-slot:item.updated_at="{item}">{{new Date(item.updated_at).toLocaleString('sv')}}</template>
                <template v-slot:top>
                    <v-toolbar flat>
                      <v-row>
                        <v-col cols="1">
                          <v-btn rounded text to="/pricelist">
                            <printer-icon/>
                          </v-btn>
                        </v-col>
                        <v-col>
                          <v-text-field
                              v-model.number="search"
                              label="Sök..."
                              clearable
                          ></v-text-field>
                        </v-col>
                      </v-row>
                    </v-toolbar>
                    <v-form class="px-4" @submit.stop.prevent="createProduct" v-model="item.valid" ref="newProduct">
                        <v-card>
                            <v-card-title>
                                <span @click="edit = !edit" style="cursor: pointer">
                                    <v-btn small icon v-if="edit">
                                        <v-icon>mdi-menu-up</v-icon>
                                    </v-btn>
                                    <v-btn small icon v-else>
                                        <v-icon>mdi-menu-down</v-icon>
                                    </v-btn>Ny Produkt
                                </span>
                            </v-card-title>
                            <v-card-text v-show="edit">
                                <template v-if="item.axfood">
                                    På axfoodkvittot så är det á-priset du vill skriva in, däremot så är rabatten redan inräknad i detta priset.<br/>
                                    Välj att antingen: Uppdatera priser varje inköp, eller dra bort rabatten från priset.
                                </template>
                                <v-row>
                                    <v-col cols="12" md="4" lg="3">
                                        <v-text-field v-model="item.name" hint="Krävs" persistent-hint label="Produkt" :rules="[rules.required]" validate-on-blur></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" lg="2">
                                        <v-text-field type="number" min="0" v-model.number="item.purchase_price" label="Förpackningspris*" hint="Krävs" persistent-hint :rules="[rules.required, rules.positive]" validate-on-blur>
                                        </v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" lg="3" class="justify-center">
                                        <v-radio-group row class="mt-0 justify-center just">
                                            <v-checkbox label="Axfood" class="mr-2" v-model="item.axfood"></v-checkbox>
                                            <v-checkbox label="Pant" class="mr-2" v-model="item.pant"></v-checkbox>
                                            <v-checkbox label="Aktiv" v-model="item.active"></v-checkbox>
                                        </v-radio-group>
                                    </v-col>
                                    <v-col cols="12" md="4" lg="2">
                                        <v-text-field type="number" min="0" hint="Krävs" persistent-hint v-model.number="item.package_size" label="Antal per Förpackning" :rules="[rules.required, rules.positive]"
                                                      validate-on-blur></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" lg="2">
                                        <v-select :items="categories" label="Kategori" hint="Krävs" persistent-hint item-text="name" item-value="id" v-model="item.category_id" :rules="[rules.required]" validate-on-blur></v-select>
                                    </v-col>
                                    <v-col cols="12" md="2">
                                        <v-text-field v-model.number="item.adjustment" label="Prisjustering" :min="((-1)*Math.ceil(item.purchase_price*1.12))" type="number"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="10">
                                        <v-combobox hint="Skriv antingen in bara artikelnumret eller som 'extra_name=article_no'" persistent-hint label="Streckkoder/Artikelnummer" v-model="item.barcodes" multiple deletable-chips
                                                    :delimiters="[',']" chips>
                                        </v-combobox>
                                    </v-col>
                                    <v-col cols="12" v-if="new_price">
                                        Försäljningspris: <strong>{{ item.purchase_price }}</strong>/<strong>{{ item.package_size }}</strong>
                                        <template v-if="item.axfood">+<strong>12%</strong></template>
                                        <template v-if="item.pant">+<strong>1</strong></template>
                                        +{{ (1 - (item.purchase_price / item.package_size * (item.axfood ? 1.12 : 1)) % 1).toFixed(2) }}(Öresavrundning)=<strong>{{ new_price }}</strong><br/>
                                        Vinst per enhet: {{ (new_price - (item.pant ? 1 : 0) - item.purchase_price / item.package_size * (item.axfood ? 1.12 : 1)).toFixed(2) }}<br/>
                                        Vinst per förpackning: {{ ((new_price - (item.pant ? 1 : 0) - item.purchase_price / item.package_size * (item.axfood ? 1.12 : 1)) * item.package_size).toFixed(2) }}
                                    </v-col>
                                    <v-col cols="12" v-else>
                                        Försäljningspris: Fyll i Pris och "Antal per Förpackning" för att visa
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col>
                                        <v-spacer></v-spacer>
                                        <v-btn type="submit" :disabled="!item.valid" :color="errors['new'] ? 'error' : 'success'" :loading="save_loading[item.id] === true">Spara</v-btn>
                                        <span :style="`color: ${$vuetify.theme.currentTheme.error}; margin: 5px;`" v-if="errors['new']">{{errors['new']}}</span>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-form>
                </template>
                <template v-slot:group.header="
                /* eslint-disable-next-line vue/no-unused-vars */
                {group,groupBy,items,headers,isOpen,toggle,remove}">
                    <td :colspan="headers.length" @click="toggle">
                        <v-btn small icon v-if="isOpen">
                            <v-icon>mdi-menu-up</v-icon>
                        </v-btn>
                        <v-btn small icon v-else>
                            <v-icon>mdi-menu-down</v-icon>
                        </v-btn>
                        {{ group.trim() }}
                    </td>
                </template>
                <template v-slot:expanded-item="{ headers, item }">
                    <td :colspan="headers.length" class="v-data-table__expanded v-data-table__expanded__content px-0" v-if="item.name !== 'DELETED'">
                        <v-card flat tile>
                            <v-card-title>
                                {{ item.name }}
                                <v-spacer></v-spacer>
                                <v-btn icon @click="deleteProduct(item)" :loading="trash_loading[item.id] === true" :color="errors['delete' + item.id] ? 'error' : 'inherit'">
                                    <v-icon>mdi-delete</v-icon>
                                    <span style="position: absolute; right: 40px;" v-if="errors['delete' + item.id]">
                                      {{errors['delete' + item.id]}}
                                    </span>
                                </v-btn>
                            </v-card-title>
                            <v-card-text>
                                <template v-if="item.axfood">
                                    På axfoodkvittot så är det á-priset du vill skriva in, däremot så är rabatten redan inräknad i detta priset.<br/>
                                    Välj att antingen: Uppdatera priser varje inköp, eller dra bort rabatten från priset.
                                </template>
                                <v-row>
                                    <v-col cols="12" md="4" lg="3">
                                        <v-text-field v-model="item.name" hint="Krävs" persistent-hint label="Produkt" :rules="[rules.required]" validate-on-blur></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" lg="2">
                                        <v-text-field type="number" min="0" v-model.number="item.purchase_price" label="Förpackningspris*" hint="Krävs" persistent-hint :rules="[rules.required, rules.positive]" validate-on-blur>
                                        </v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" lg="3" class="justify-center">
                                        <v-radio-group row class="mt-0 justify-center just">
                                            <v-checkbox label="Axfood" class="mr-2" v-model="item.axfood"></v-checkbox>
                                            <v-checkbox label="Pant" class="mr-2" v-model="item.pant"></v-checkbox>
                                            <v-checkbox label="Aktiv" v-model="item.active"></v-checkbox>
                                        </v-radio-group>
                                    </v-col>
                                    <v-col cols="12" md="4" lg="2">
                                        <v-text-field type="number" min="0" hint="Krävs" persistent-hint v-model.number="item.package_size" label="Antal per Förpackning" :rules="[rules.required, rules.positive]"
                                                      validate-on-blur></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" lg="2">
                                        <v-select :items="categories" label="Kategori" hint="Krävs" persistent-hint item-text="name" item-value="id" v-model="item.category_id" :rules="[rules.required]" validate-on-blur></v-select>
                                    </v-col>
                                    <v-col cols="12" md="2">
                                        <v-text-field v-model.number="item.adjustment" label="Prisjustering" :min="((-1)*Math.ceil(item.purchase_price*1.12))" type="number"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="10">
                                        <v-combobox hint="Skriv antingen in bara artikelnumret eller som 'extra_name=article_no'" persistent-hint label="Streckkoder/Artikelnummer" v-model="item.combobox_barcodes" multiple deletable-chips
                                                    :delimiters="[' ', ',', '.']" chips>
                                        </v-combobox>
                                    </v-col>
                                    <v-col cols="12" v-if="!(isNaN(item.purchase_price) || isNaN(item.package_size) || !item.package_size)">
                                        Försäljningspris: <strong>{{ item.purchase_price }}</strong>/<strong>{{ item.package_size }}</strong>
                                        <template v-if="item.axfood">+<strong>12%</strong></template>
                                        <template v-if="item.pant">+<strong>1</strong></template>
                                        +Öresavrundning=<strong>{{ (Math.ceil((item.purchase_price * (item.axfood ? 1.12 : 1)) / item.package_size + (item.pant ? 1 : 0) + (item.adjustment ? item.adjustment : 0))) }}</strong><br/>
                                        Vinst per enhet:
                                        {{
                                            (Math.ceil((item.purchase_price * (item.axfood ? 1.12 : 1)) / item.package_size + (item.pant ? 1 : 0) + (item.adjustment ? item.adjustment : 0)) - (item.pant ? 1 : 0) - item.purchase_price / item.package_size * (item.axfood ? 1.12 : 1)).toFixed(2)
                                        }}<br/>
                                        Vinst per förpackning:
                                        {{
                                            ((Math.ceil((item.purchase_price * (item.axfood ? 1.12 : 1)) / item.package_size + (item.pant ? 1 : 0) + (item.adjustment ? item.adjustment : 0)) - (item.pant ? 1 : 0) - item.purchase_price / item.package_size * (item.axfood ? 1.12 : 1)) * item.package_size).toFixed(2)
                                        }}
                                    </v-col>
                                    <v-col cols="12" v-else>
                                        Försäljningspris: Fyll i Pris och "Antal per Förpackning" för att visa
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col>
                                        <v-spacer></v-spacer>
                                        <v-btn type="submit" :color="errors[item.id] ? 'error' : 'success'" @click="updateProduct(item)">Spara</v-btn>
                                        <span v-if="save_loading[item.id] === 'success'" style="margin: 5px;">Sparad!</span>
                                        <span :style="`color: ${$vuetify.theme.currentTheme.error}; margin: 5px;`" v-if="errors[item.id]">{{errors[item.id]}}</span>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </td>
                </template>
            </v-data-table>
        </v-card-text>
    </v-card>
</template>

<script>
import { PrinterIcon } from 'vue-feather-icons'

export default {
    name: "Prices",
    data() {
        return {
            state: import('@/assets/ts/sessionStore'),
            trash_loading: [],
            save_loading: [],
            errors: [],
            search: '',
            categories: [],
            expanded: [],
            loading: true,
            edit: false,
            items: [],
            item: {
                valid: false,
                name: '',
                purchase_price: null,
                discount: 0,
                adjustment: 0,
                price: null,
                active: true,
                pant: false,
                package_size: null,
                updated_at: '',
                axfood: true,
                category_id: null,
                category_name: '',
                combobox_barcodes: []
            },
            rules: {
                required: value => {
                    return value ? true : "Fältet är obligatoriskt"
                },
                positive: value => {
                    return value > 0 ? true : "Måste vara större än 0"
                },
            },
            headers: [
                {
                    text: 'Produkt',
                    align: 'start',
                    filterable: true,
                    value: 'name',
                    groupable: false,
                },
                {
                    text: 'Kategori',
                    align: 'center',
                    filterable: true,
                    value: 'category_name',
                    groupable: true,
                },
                {
                    text: 'Pris',
                    align: 'center',
                    filterable: true,
                    value: 'price',
                    groupable: false,
                },
              {
                text: 'Senast updaterad',
                value: 'updated_at',
                align: 'right',
                groupable: false
              }
            ]
        }
    },
  components:{
    PrinterIcon
  },
    computed: {
        new_price() {
            if (isNaN(this.item.purchase_price) || isNaN(this.item.package_size) || !this.item.package_size) {
                return false;
            }
            return Math.ceil((this.item.purchase_price * (this.item.axfood ? 1.12 : 1)) / this.item.package_size + (this.item.pant ? 1 : 0) + (this.item.adjustment ? this.item.adjustment : 0))
        }
    },
    created() {
        this.getItems();
    },
    methods: {
        createProduct() {
            if (!this.$refs.newProduct.validate()) {
                return
            }

            this.$set(this.errors, 'new', '')
            this.item.price = (Math.ceil((this.item.purchase_price * (this.item.axfood ? 1.12 : 1)) / this.item.package_size + (this.item.pant ? 1 : 0) + (this.item.adjustment ? this.item.adjustment : 0)))

            this.state.then(obj => {
              delete this.item.valid
              fetch(process.env.VUE_APP_API_URL + `/loehk/prices`, {

                // Adding method type
                method: "POST",

                // Convert to JSON and send
                body: JSON.stringify(this.item),

                // Adding headers to the request
                headers: {
                  "Content-type": "application/json; charset=UTF-8",
                  sessionId: obj.SessionStore.getSessionId()
                }
              })
                // Convert to JSON and convey success
                .then(res => {
                  if (res.ok) {
                    this.$set(this, 'item', {
                      valid: false,
                      name: '',
                      purchase_price: null,
                      discount: 0,
                      adjustment: 0,
                      price: null,
                      active: true,
                      pant: false,
                      package_size: null,
                      updated_at: '',
                      axfood: true,
                      category_id: null,
                      category_name: '',
                      combobox_barcodes: []
                    })
                    this.getItems()
                  } else {
                    if (res.status === 422) {
                      this.$set(this.errors, 'new',
                        'det var ett problem med att hantera datan, produkten kanske redan existerar eller så är viktiga fält tomma')
                    } else if (res.status === 403) {
                      this.$set(this.errors, 'new', 'utloggad, refresh?')
                    } else {
                      this.$set(this.errors, 'new', 'servern stötte på ett problem när den hanterade datan')
                    }
                  }
                })
                .catch((err) => {
                  console.error(err)
                  this.$set(this.errors, 'new', 'kunde inte nå servern')
                })
                .finally(() => {
                  this.$set(this, "loading", false);
                })
            })
        },
        deleteProduct(item) {
            this.$set(this.trash_loading, item.id, true)
            this.$set(this.errors, 'delete' + item.id, '')

          this.state.then(obj => {
            fetch(process.env.VUE_APP_API_URL + `/loehk/prices/` + item.id, {

              // Adding method type
              method: "DELETE",

              // Adding headers to the request
              headers: {
                "Content-type": "application/json; charset=UTF-8",
                sessionId: obj.SessionStore.getSessionId()
              }
            })
              // Convey success
              .then(res => {
                if (res.ok) {
                  this.$set(item, 'name', 'DELETED')
                } else {
                  if (res.status === 403) {
                    this.$set(this.errors, 'delete' + item.id, 'utloggad, refresh?')
                  } else {
                    this.$set(this.errors, 'delete' + item.id, 'servern gick på något fel när den försökte ta bort produkten')
                  }
                }
              }).catch(() => {
              this.$set(this.errors, 'delete' + item.id, 'kunde inte nå servern')
            }).finally(() => {
              this.$set(this.trash_loading, item.id, "success")
            })
          })
        },
        updateProduct(item) {
            this.$set(this.save_loading, item.id, true)
            this.$set(this.errors, item.id, '')
            item.price = (Math.ceil((item.purchase_price * (item.axfood ? 1.12 : 1)) / item.package_size + (item.pant ? 1 : 0) + (item.adjustment ? item.adjustment : 0)))

          this.state.then(obj => {
            fetch(process.env.VUE_APP_API_URL + `/loehk/prices`, {

              // Adding method type
              method: "PUT",

              // Convert to JSON and send
              body: JSON.stringify(item),

              // Adding headers to the request
              headers: {
                "Content-type": "application/json; charset=UTF-8",
                sessionId: obj.SessionStore.getSessionId()
              }
            })
              // Convey success
              .then(res => {
                if (res.ok) {
                  this.$set(this.save_loading, item.id, 'success')
                } else {
                  this.$set(this.save_loading, item.id, false)
                  if (res.status === 422) {
                    this.$set(this.errors, item.id, 'det är något fel med detan, antigen så har produkten samma namn som en annnan produkt eller så är ett viktigt fält tomt')
                  } else if (res.status === 403) {
                    this.$set(this.errors, item.id, 'utloggad, refresh?')
                  } else {
                    this.$set(this.errors, item.id, 'servern stötte på något fel när den hanterade datan')
                  }
                }
              }).catch(() => {
              this.$set(this.save_loading, item.id, false)
              this.$set(this.errors, item.id, 'kunde inte nå servern')
              // eslint-disable-next-line @typescript-eslint/no-empty-function
            }).finally(() => {
            })
          })
        },
        expandRow(row) {
            this.expanded = row === this.expanded[0] ? [] : [row]
            console.log(this.items[row])
            console.log(this.categories)
        },
        getItems() {
            this.$set(this, "loading", true);

            this.state.then(obj => {
              fetch (
                process.env.VUE_APP_API_URL + '/loehk/prices', {
                headers: {
                  sessionId: obj.SessionStore.getSessionId()
                }
              })
                .then(res => res.json())
                .then(res => {
                  this.$set(this, "items", res.products);
                  this.$set(this, "categories", res.categories);
                })
                .catch((err) => {
                  console.error(err)
                  this.$router.push('/login')
                })
                .finally(() => {
              this.$set(this, "loading", false);
            })
        })
        }
    }
}
</script>

<style scoped>

</style>
