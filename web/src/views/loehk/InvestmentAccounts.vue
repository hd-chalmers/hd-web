<template>
    <v-card>
        <v-card-actions>
            <v-btn icon href="/loehk/streck/print">
                <v-icon>mdi-printer</v-icon>
            </v-btn>
        </v-card-actions>
        <v-card-title>
            Strecklistan
        </v-card-title>
        <v-card-text>
            <v-data-table :items="accounts"
                          :headers="headers"
                          item-key="id"
                          :loading="loading"
                          loading-text="Hämtar produkter..."
                          :dense="!($vuetify.breakpoint.mobile)"
                          :items-per-page="-1"
                          group-by="active_text"
                          :single-expand="true"
                          show-expand
                          :search="search"
                          @click:row="expandRow"
                          :expanded="expanded">
                <template v-slot:top>
                    <v-card color="mb-1">
                        <v-card-title>Ny Användare</v-card-title>
                        <v-card-text>
                            <v-form>
                                <v-row dense>
                                    <v-col cols="12" sm="6" md="4" lg="4">
                                        <v-text-field label="Streckkod" v-model="account.uid"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4" lg="4">
                                        <v-text-field label="Namn" v-model="account.name"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4" lg="4">
                                        <v-text-field label="Lösenord" v-model="account.password"></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-btn color="success" @click="createAccount(account)">Spara</v-btn>
                                    </v-col>
                                </v-row>
                            </v-form>
                        </v-card-text>
                    </v-card>
                    <v-toolbar flat>
                        <v-text-field
                            v-model.number="search"
                            label="Sök..."
                            clearable
                        ></v-text-field>
                    </v-toolbar>
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
                                <v-btn icon @click="deleteAccount(item)" :loading="trash_loading[item.id] === true">
                                    <v-icon>mdi-delete</v-icon>
                                </v-btn>
                            </v-card-title>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12" sm="6" md="4" lg="3">
                                        <v-text-field label="Streckkod" v-model="item.uid"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4" lg="3">
                                        <v-text-field label="Namn" v-model="item.name"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4" lg="3">
                                        <v-text-field label="Kontobalans" type="number" v-model.number="item.balance" disabled readonly></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4" lg="3">
                                        <v-text-field label="Lösenord" v-model="item.password"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4" lg="3">
                                        <v-radio-group row>
                                            <v-switch class="mr-1" label="Skriv ut" v-model="item.print"></v-switch>
                                            <v-switch label="Aktiv" v-model="item.active"></v-switch>
                                        </v-radio-group>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col>
                                        <v-spacer></v-spacer>
                                        <v-btn type="submit" color="green" @click="updateAccount(item)">Spara</v-btn>
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
    name: "InvestmentAccounts",
    data() {
        return {
            trash_loading: [],
            save_loading: [],
            search: '',
            categories: [],
            expanded: [],
            loading: true,
            edit: false,
            accounts: [],
            account: {
                name: null,
                uid: null,
                password: null,
                balance: null,
                active: null,
                print: null,
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
                    text: 'Streckkod',
                    align: 'start',
                    filterable: true,
                    value: 'uid',
                    groupable: false,
                },
                {
                    text: 'Namn',
                    align: 'left',
                    filterable: true,
                    value: 'name',
                    groupable: false,
                },
                {
                    text: 'Kontobalans',
                    align: 'right',
                    filterable: false,
                    value: 'balance',
                    groupable: false,
                },
                {
                    text: 'Aktiv',
                    align: 'center',
                    filterable: false,
                    value: 'active_text',
                    groupable: true,
                },
            ]
        }
    },
    created() {
        this.getItems();
    },
    methods: {
        expandRow(row) {
            this.expanded = row === this.expanded[0] ? [] : [row]
        },
        deleteAccount(item) {
            this.$set(this.trash_loading, item.id, true)
            fetch(`http://localhost:8000/loehk/investments`, {

            // Adding method type
            method: "DELETE",

            // Convert to JSON and send
            body: JSON.stringify({accountId: item.id}),

            // Adding headers to the request
            headers: {
              "Content-type": "application/json; charset=UTF-8"
            }
          })
              // Convey success
                .then(res => {
                this.$set(item, 'name', "DELETED")
              // eslint-disable-next-line @typescript-eslint/no-empty-function
            }).catch(() => {
            }).finally(() => {
                this.$set(this.trash_loading, item.id, "success")
            })
        },
        createAccount(item) {
            this.$set(this.save_loading, 'new', true)
            fetch(`http://localhost:8000/loehk/investments`, {

            // Adding method type
            method: "POST",

            // Convert to JSON and send
            body: JSON.stringify(item),

            // Adding headers to the request
            headers: {
              "Content-type": "application/json; charset=UTF-8"
            }
          })
              // Convert to json and convey success
                .then(res => res.json()).then(res => {
                this.$set(this.save_loading, 'new', "success")
                this.$set(this.accounts, this.accounts.length, res)
                this.account =  {
                    name: null,
                    uid: null,
                    password: null,
                    balance: null,
                    active: null,
                    print: null,
                };
            }).catch(() => {
                this.$set(this.save_loading, 'new', "failed")
              // eslint-disable-next-line @typescript-eslint/no-empty-function
            }).finally(() => {
            })
        },
        updateAccount(item) {
            this.$set(this.save_loading, item.id, true)
            fetch(`http://localhost:8000/loehk/investments?accountId=${item.id}`, {

            // Adding method type
            method: "PUT",

            // Convert to JSON and send
            body: JSON.stringify(item),

            // Adding headers to the request
            headers: {
              "Content-type": "application/json; charset=UTF-8"
            }
          })
          // Convey success
                .then(res => {
                this.$set(this.save_loading, item.id, "success")
                item = res.data;
            }).catch(() => {
                this.$set(this.save_loading, item.id, "failed")
              // eslint-disable-next-line @typescript-eslint/no-empty-function
            }).finally(() => {
            })
        },
        getItems() {
            this.$set(this, "loading", true);
            fetch('http://localhost:8000/loehk/investments').then(res =>res.json())
                .then(res => {
                this.$set(this, "accounts", res.active);
                this.$set(this, "accounts", this.accounts.concat(res.inactive));
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
