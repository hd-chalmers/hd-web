<template>
    <v-row>
        <v-col style="max-width: 1000px">
            <v-card :loading="loading">
                <v-card-title>
                    Statistik
                </v-card-title>
                <v-card-text>
                    <v-list>
                        <v-list-item-group>
                            <v-list-item>
                                <v-list-item-title>
                                    Antal Spel:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.games }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <v-list-item v-if="stats.games_latest !== null">
                                <v-list-item-title>
                                    Senaste Spel:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.games_latest.name }} - {{ stats.games_latest.created_at.substr(0, 10) }} {{ stats.games_latest.created_at.substr(11, 8) }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <v-list-item  v-if="stats.games_updated !== null">
                                <v-list-item-title>
                                    Senast uppdaterade Spel:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.games_updated.name }} - {{ stats.games_updated.updated_at.substr(0, 10) }} {{ stats.games_updated.updated_at.substr(11, 8) }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <hr>
                            <v-list-item>
                                <v-list-item-title>
                                    Antal Produkter:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.products }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <v-list-item  v-if="stats.product_latest !== null">
                                <v-list-item-title>
                                    Senaste Produkt:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.product_latest.name }} - {{ stats.product_latest.created_at.substr(0, 10) }} {{ stats.product_latest.created_at.substr(11, 8) }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <v-list-item  v-if="stats.product_updated !== null">
                                <v-list-item-title>
                                    Senast uppdaterade Produkt:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.product_updated.name }} - {{ stats.product_updated.updated_at.substr(0, 10) }} {{ stats.product_updated.updated_at.substr(11, 8) }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <hr>
                            <v-list-item>
                                <v-list-item-title>
                                    Antal Strecklistor:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.investment_accounts }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-title>
                                    Senaste Strecklista:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.investment_latest.name }} - {{ stats.investment_latest.created_at.substr(0, 10) }} {{ stats.investment_latest.created_at.substr(11, 8) }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-title>
                                    Senast uppdaterade Strecklista:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.investment_updated.name }} - {{ stats.investment_updated.updated_at.substr(0, 10) }} {{ stats.investment_updated.updated_at.substr(11, 8) }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <hr>
                            <v-list-item>
                                <v-list-item-title>
                                    Antal Events:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.events }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-title>
                                    Senaste Event:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.event_latest.title }} - {{ stats.event_latest.created_at.substr(0, 10) }} {{ stats.event_latest.created_at.substr(11, 8) }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-title>
                                    Senast uppdaterade Event:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.event_updated.title }} - {{ stats.event_updated.updated_at.substr(0, 10) }} {{ stats.event_updated.updated_at.substr(11, 8) }}
                                </v-list-item-subtitle>
                            </v-list-item>
                        </v-list-item-group>
                    </v-list>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
import axios from 'axios'

export default {
    name: "Front",
    created() {
        this.getStatistics();
    },
    data() {
        return {
            loading: true,
            stats: {
                products: 0,
                product_updated: {
                    name: "",
                    updated_at: ""
                },
                product_latest: {
                    name: "",
                    created_at: ""
                },
                investment_accounts: 0,
                investment_latest: {
                    uid: "",
                    name: "",
                    created_at: ""
                },
                investment_updated: {
                    uid: "",
                    name: "",
                    updated_at: ""
                },
                events: 0,
                event_latest: {
                    title: "",
                    created_at: "",
                    date: ""
                },
                event_updated: {
                    title: "",
                    updated_at: "",
                    date: ""
                },
                games: 0,
                games_latest: {
                    name: "",
                    created_at: "",
                    platform: "",
                },
                games_updated: {
                    name: "",
                    updated_at: "",
                    platform: "",
                }
            }
        }
    },
    methods: {
        getStatistics() {
            axios(
                "/loehk/stats",
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
                this.stats = res.data
              // eslint-disable-next-line @typescript-eslint/no-empty-function
            }).catch(() => {
            }).finally(() => {
                this.loading = false;
            })
        }
    }
}
</script>

<style scoped>

</style>
