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
                          :expanded="expanded">
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-text-field
                            v-model.number="search"
                            label="Sök..."
                            clearable
                        ></v-text-field>
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
                                        <v-btn type="submit" :disabled="!item.valid" color="green" :loading="save_loading[item.id] === true">Spara</v-btn>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-form>
                </template>
                <template v-slot="
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
                                <v-btn icon @click="deleteProduct(item)" :loading="trash_loading[item.id] === true">
                                    <v-icon>mdi-delete</v-icon>
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
                                        <v-btn type="submit" color="green" @click="updateProduct(item)">Spara</v-btn>
                                        <span v-if="save_loading[item.id] === 'success'">Sparad!</span>
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
import axios from 'axios'

export default {
    name: "Prices",
    data() {
        return {
            trash_loading: [],
            save_loading: [],
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
                discount: null,
                adjustment: 0,
                price: null,
                active: true,
                pant: false,
                package_size: null,
                created_at: '',
                updated_at: '',
                axfood: true,
                barcodes: [],
                category_id: null,
                category: {
                    name: '',
                    created_at: '',
                    updated_at: '',
                }
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
            ]
        }
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
        createProduct(e) {
            if (!this.$refs.newProduct.validate()) {
                return
            }

            this.item.price = (Math.ceil((this.item.purchase_price * (this.item.axfood ? 1.12 : 1)) / this.item.package_size + (this.item.pant ? 1 : 0) + (this.item.adjustment ? this.item.adjustment : 0)))

            axios(
                "/loehk/prices",
                {
                    method:
                        'post',
                    withCredentials:
                        true,
                    responseType:
                        'json',
                    timeout: 3000,
                    headers:
                        {
                            'Content-Type':
                                'application/json',
                            'Accept':
                                'application/json',
                        },
                    data: JSON.stringify(this.item),
                }).then(res => {
                this.$set(this, "items", res.data.products);
                this.$set(this, "categories", res.data.categories);
                this.$set(this, "item", {
                    valid: false,
                    name: '',
                    purchase_price: null,
                    discount: null,
                    adjustment: 0,
                    price: null,
                    active: true,
                    pant: false,
                    package_size: null,
                    created_at: '',
                    updated_at: '',
                    axfood: true,
                    barcodes: [],
                    category_id: null,
                    category: {
                        name: '',
                        created_at: '',
                        updated_at: '',
                    }
                })
              // eslint-disable-next-line @typescript-eslint/no-empty-function
            }).catch(() => {
            }).finally(() => {
                this.$set(this, "loading", false);
            })
        },
        deleteProduct(item) {
            this.$set(this.trash_loading, item.id, true)
            axios(
                "/loehk/prices/" + item.id,
                {
                    method:
                        'DELETE',
                    withCredentials:
                        true,
                    responseType:
                        'json',
                    timeout: 3000,
                    headers:
                        {
                            'Content-Type':
                                'application/json',
                            'Accept':
                                'application/json',
                        },
                    data: JSON.stringify(item),
                }).then(res => {
                this.$set(item, 'name', "DELETED")
              // eslint-disable-next-line @typescript-eslint/no-empty-function
            }).catch(() => {
            }).finally(() => {
                this.$set(this.trash_loading, item.id, "success")
            })
        },
        updateProduct(item) {
            this.$set(this.save_loading, item.id, true)
            item.price = (Math.ceil((item.purchase_price * (item.axfood ? 1.12 : 1)) / item.package_size + (item.pant ? 1 : 0) + (item.adjustment ? item.adjustment : 0)));
            axios(
                "/loehk/prices/" + item.id,
                {
                    method:
                        'PATCH',
                    withCredentials:
                        true,
                    responseType:
                        'json',
                    timeout: 3000,
                    headers:
                        {
                            'Content-Type':
                                'application/json',
                            'Accept':
                                'application/json',
                        },
                    data: JSON.stringify(item),
                }).then(res => {
                this.$set(this.save_loading, item.id, "success")
            }).catch(() => {
                this.$set(this.save_loading, item.id, "failed")
              // eslint-disable-next-line @typescript-eslint/no-empty-function
            }).finally(() => {
            })
        },
        expandRow(row) {
            this.expanded = row === this.expanded[0] ? [] : [row]
        },
        getItems() {
            this.$set(this, "loading", true);
            axios(
                "/loehk/prices",
                {
                    method:
                        'get',
                    withCredentials:
                        true,
                    responseType:
                        'json',
                    timeout: 3000,
                    headers:
                        {
                            'Content-Type':
                                'application/json',
                            'Accept':
                                'application/json',
                        },
                }).then(res => {
                this.$set(this, "items", res.data.products);
                this.$set(this, "categories", res.data.categories);
              // eslint-disable-next-line @typescript-eslint/no-empty-function
            }).catch(() => {
            }).finally(() => {
                this.$set(this, "loading", false);
            })
        }
    }
}
</script>

<style scoped>

</style>
