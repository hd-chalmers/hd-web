<router>
{
  beforeEnter:
    (to, from, next) => {
      import('@/store/sessionStore').then(c => {
        if (c.SessionStore.getSessionId() === null) {
          next("/login")
        } else {
          next()
        }
      })
    }
}
</router>

<template>
    <v-card>
        <v-card-text>
            <v-data-table :items="items"
                          :headers="$vuetify.breakpoint.xs ? [headers[0]] :headers"
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
                    <v-card>
                      <v-row>
                        <v-col cols="12" sm="1">
                          <v-btn rounded text to="/pricelist">
                            <printer-icon/>
                          </v-btn>
                        </v-col>
                        <v-col>
                          <v-text-field
                              v-model.number="search"
                              label="Sök..."
                              clearable
                              outlined
                              style="margin: 0 10px;"
                          >
                            <template v-slot:prepend-inner> <search-icon size="1.4x"/> </template>
                          </v-text-field>
                        </v-col>
                      </v-row>
                      <v-expansion-panels>
                        <v-expansion-panel class="elevation-2">
                          <v-expansion-panel-header>
                            <v-card-title style="padding: 0"> <plus-circle-icon style="margin-right: 5px;"/> Ny Produkt </v-card-title>
                          </v-expansion-panel-header>
                          <v-expansion-panel-content>
                            <v-form class="px-4" @submit.stop.prevent="createProduct" v-model="item.valid" ref="newProduct">
                                        <div v-if="item.axfood" style="margin-bottom: 5px;">
                                            På axfoodkvittot så är det á-priset du vill skriva in, däremot så är rabatten redan inräknad i detta priset.<br/>
                                            Välj att antingen: Uppdatera priser varje inköp, eller dra bort rabatten från priset.
                                        </div>

                                        <v-row>
                                            <v-col cols="12" md="4" lg="3">
                                                <v-text-field v-model="item.name" hint="Krävs" persistent-hint label="Produkt" :rules="[rules.required]" validate-on-blur></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="4" lg="2">
                                                <v-text-field type="number" min="0" v-model.number="item.purchase_price" label="Förpackningspris*" hint="Krävs" persistent-hint
                                                              :rules="[rules.required, rules.positive]" validate-on-blur suffix="kr">
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
                                                              validate-on-blur suffix="st"></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="4" lg="2">
                                                <v-select :items="categories" label="Kategori" hint="Krävs" persistent-hint item-text="name" item-value="id" v-model="item.category_id" :rules="[rules.required, rules.positive]" validate-on-blur></v-select>
                                            </v-col>
                                            <v-col cols="12" md="2">
                                                <v-text-field v-model.number="item.adjustment" label="Prisjustering" :min="((-1)*Math.ceil(item.purchase_price*1.12))" type="number" suffix="kr"></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="10">
                                                <v-combobox hint="Skriv antingen in bara artikelnumret eller som 'extra_name=article_no'. Ange $ i början för att markera att det är ett flak." persistent-hint label="Streckkoder/Artikelnummer" v-model="item.combobox_barcodes" multiple deletable-chips
                                                            :delimiters="[',']" chips outlined>
                                                </v-combobox>
                                            </v-col>
                                            <v-col cols="12" v-if="new_price">
                                                Försäljningspris: <strong>{{ item.purchase_price }}</strong>/<strong>{{ item.package_size }}</strong>
                                                <template v-if="item.axfood">+<strong>12%</strong></template>
                                                <template v-if="item.pant">+<strong>1</strong></template>
                                                +{{ (1 - (item.purchase_price / item.package_size * (item.axfood ? 1.12 : 1)) % 1).toFixed(2) }}(Öresavrundning)=<strong>{{ new_price }}</strong> kr<br/>
                                                Vinst per enhet: {{ (new_price - (item.pant ? 1 : 0) - item.purchase_price / item.package_size * (item.axfood ? 1.12 : 1)).toFixed(2) }} kr<br/>
                                                Vinst per förpackning: {{ ((new_price - (item.pant ? 1 : 0) - item.purchase_price / item.package_size * (item.axfood ? 1.12 : 1)) * item.package_size).toFixed(2) }} kr
                                            </v-col>
                                            <v-col cols="12" v-else>
                                                Försäljningspris: Fyll i Pris och "Antal per Förpackning" för att visa
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <v-spacer></v-spacer>
                                                <v-btn type="submit" :color="errors['new'] ? 'error' : 'success'" :loading="save_loading[item.id] === true">Spara</v-btn>
                                                <span :style="`color: ${$vuetify.theme.currentTheme.error}; margin: 5px;`" v-if="errors['new']">{{errors['new']}}</span>
                                            </v-col>
                                        </v-row>
                            </v-form>
                          </v-expansion-panel-content>
                        </v-expansion-panel>
                      </v-expansion-panels>
                    </v-card>
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
                                <div v-if="item.axfood" style="margin-bottom: 10px;">
                                    På axfoodkvittot så är det á-priset du vill skriva in, däremot så är rabatten redan inräknad i detta priset.<br/>
                                    Välj att antingen: Uppdatera priser varje inköp, eller dra bort rabatten från priset.
                                </div>
                                <v-row>
                                    <v-col cols="12" md="4" lg="3">
                                        <v-text-field v-model="item.name" hint="Krävs" persistent-hint label="Produkt" :rules="[rules.required]" validate-on-blur></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" lg="2">
                                        <v-text-field type="number" min="0" v-model.number="item.purchase_price" label="Förpackningspris*" hint="Krävs" persistent-hint
                                                      :rules="[rules.required, rules.positive]" validate-on-blur suffix="kr">
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
                                                      validate-on-blur suffix="st"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" lg="2">
                                        <v-select :items="categories" label="Kategori" hint="Krävs" persistent-hint item-text="name" item-value="id" v-model="item.category_id" :rules="[rules.required]" validate-on-blur></v-select>
                                    </v-col>
                                    <v-col cols="12" md="2">
                                        <v-text-field v-model.number="item.adjustment" label="Prisjustering" :min="((-1)*Math.ceil(item.purchase_price*1.12))" type="number" suffix="kr"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="10">
                                        <v-combobox hint="Skriv antingen in bara artikelnumret eller som 'extra_name=article_no'. Ange $ i början för att markera att det är ett flak." persistent-hint label="Streckkoder/Artikelnummer" v-model="item.combobox_barcodes" multiple deletable-chips
                                                    :delimiters="[' ', ',', '.']" chips outlined>
                                        </v-combobox>
                                    </v-col>
                                    <v-col cols="12" v-if="!(isNaN(item.purchase_price) || isNaN(item.package_size) || !item.package_size)">
                                        Försäljningspris: <strong>{{ item.purchase_price }}</strong>/<strong>{{ item.package_size }}</strong>
                                        <template v-if="item.axfood">+<strong>12%</strong></template>
                                        <template v-if="item.pant">+<strong>1</strong></template>
                                        +Öresavrundning= <strong>{{ (Math.ceil((item.purchase_price * (item.axfood ? 1.12 : 1)) / item.package_size + (item.pant ? 1 : 0) + (item.adjustment ? item.adjustment : 0))) }}</strong> kr<br/>
                                        Vinst per enhet:
                                        {{
                                            (Math.ceil((item.purchase_price * (item.axfood ? 1.12 : 1)) / item.package_size + (item.pant ? 1 : 0) + (item.adjustment ? item.adjustment : 0)) - (item.pant ? 1 : 0) - item.purchase_price / item.package_size * (item.axfood ? 1.12 : 1)).toFixed(2)
                                        }} kr<br/>
                                        Vinst per förpackning:
                                        {{
                                            ((Math.ceil((item.purchase_price * (item.axfood ? 1.12 : 1)) / item.package_size + (item.pant ? 1 : 0) + (item.adjustment ? item.adjustment : 0)) - (item.pant ? 1 : 0) - item.purchase_price / item.package_size * (item.axfood ? 1.12 : 1)) * item.package_size).toFixed(2)
                                        }} kr
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

<script lang="ts">


import {Component, Vue} from "vue-property-decorator"
import { PrinterIcon, SearchIcon, PlusCircleIcon } from 'vue-feather-icons'
import {LoehkProductData, ProductCategory} from "@/assets/interfaces";
import {SessionStore} from "@/store/sessionStore";

@Component<LoehkPrices>({
  components: { PrinterIcon, SearchIcon, PlusCircleIcon },
  layout:"loehk",
  computed: {
    new_price() {
      if (isNaN(this.item.purchase_price) || isNaN(this.item.package_size) || !this.item.package_size) {
        return false;
      }
      return Math.ceil((this.item.purchase_price * (this.item.axfood ? 1.12 : 1)) / this.item.package_size + (this.item.pant ? 1 : 0) + (this.item.adjustment ? this.item.adjustment : 0))
    }
  }
})
export default class LoehkPrices extends Vue{
  constructor() {
    super()
    this.getItems()
  }

  //state = import('@/assets/ts/sessionStore')
  trash_loading: boolean[] = []
  save_loading: boolean[] = []
  errors: string[] = []
  search = ''
  categories: ProductCategory[] = []
  expanded: number[] = []
  loading = true
  edit = false
  items: LoehkProductData[] = []
  item: LoehkProductData = {
    id: -1,
    valid: false,
    name: '',
    purchase_price: 0,
    discount: 0,
    adjustment: 0,
    price: 0,
    active: true,
    pant: false,
    package_size: 0,
    updated_at: '',
    axfood: true,
    category_id: -1,
    category_name: '',
    combobox_barcodes: []
  }
  rules = {
      required: (value: string): true | string => {
      return value ? true : "Fältet är obligatoriskt"
    },
      positive: (value: number): true | string => {
      return value > 0 ? true : "Måste vara större än 0"
    }
  }
  headers = [
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

  createProduct():void {
    (this.$refs as unknown as { newProduct:{validate: () => boolean} }).newProduct.validate()
    if (!this.item.valid) {
      return
    }

    this.$set(this.errors, 'new', '')
    this.item.price = (Math.ceil((this.item.purchase_price * (this.item.axfood ? 1.12 : 1)) / this.item.package_size + (this.item.pant ? 1 : 0) + (this.item.adjustment ? this.item.adjustment : 0)))

    //this.state.then(obj => {
      delete this.item.valid
      fetch(process.env.NUXT_ENV_API_URL + `/loehk/prices`, {

        // Adding method type
        method: "POST",

        // Convert to JSON and send
        body: JSON.stringify(this.item),

        // Adding headers to the request
        headers: {
          "Content-type": "application/json; charset=UTF-8",
          Authorization: SessionStore.getSessionId() ?? ""
        }
      })
        // Convert to JSON and convey success
        .then(res => {
          if (res.ok) {
            this.item = {
              id: -1,
              valid: false,
              name: '',
              purchase_price: 0,
              discount: 0,
              adjustment: 0,
              price: 0,
              active: true,
              pant: false,
              package_size: 0,
              updated_at: '',
              axfood: true,
              category_id: -1,
              category_name: '',
              combobox_barcodes: []
            };

            (this.$refs as unknown as {newProduct: {resetValidation: () => void}}).newProduct.resetValidation()
            console.log("Created")
            console.log(this.item)
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
          this.loading = false
        })
    //})
  }
  deleteProduct(item: LoehkProductData): void {
    this.$set(this.trash_loading, item.id, true)
    this.$set(this.errors, 'delete' + item.id, '')

    //this.state.then(obj => {
      fetch(process.env.NUXT_ENV_API_URL + `/loehk/prices/` + item.id, {

        // Adding method type
        method: "DELETE",

        // Adding headers to the request
        headers: {
          "Content-type": "application/json; charset=UTF-8",
          Authorization: SessionStore.getSessionId() ?? ""
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
    //})
  }
  updateProduct(item: LoehkProductData): void {
    this.$set(this.save_loading, item.id, true)
    this.$set(this.errors, item.id, '')
    item.price = (Math.ceil((item.purchase_price * (item.axfood ? 1.12 : 1)) / item.package_size + (item.pant ? 1 : 0) + (item.adjustment ? item.adjustment : 0)))

    //this.state.then(obj => {
      fetch(process.env.NUXT_ENV_API_URL + `/loehk/prices`, {

        // Adding method type
        method: "PUT",

        // Convert to JSON and send
        body: JSON.stringify(item),

        // Adding headers to the request
        headers: {
          "Content-type": "application/json; charset=UTF-8",
          Authorization: SessionStore.getSessionId() ?? ""
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
    //})
  }
  expandRow(row: number): void {
    this.expanded = row === this.expanded[0] ? [] : [row]
  }

  getItems(): void {
    this.loading = true

    //this.state.then(obj => {
      fetch (
        process.env.NUXT_ENV_API_URL + '/loehk/prices', {
          headers: {
            Authorization: SessionStore.getSessionId() ?? ""
          }
        })
        .then(res => res.json())
        .then((res: {products: LoehkProductData[], categories: ProductCategory[]}) => {
          this.items = res.products
          this.categories = res.categories
        })
        .catch((err) => {
          console.error(err)
          this.$router.push('/login')
        })
        .finally(() => {
          this.loading = false
        })
    //})
  }
}
</script>

<style scoped>

</style>
