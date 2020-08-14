<template>
    <v-container :fluid="$vuetify.breakpoint.mobile">
        <v-card>
            <v-card-actions>
            </v-card-actions>
            <v-card-text>
                <v-data-table :items="games"
                              :headers="headers"
                              item-key="id"
                              :loading="loading"
                              loading-text="Hämtar våra spel..."
                              :dense="!($vuetify.breakpoint.mobile)"
                              :items-per-page="-1"
                              group-by="platform"
                              :single-expand="true"
                              show-expand
                              :search="search.name"
                              @click:row="expandRow"
                              :expanded="expanded"
                              :mobile-breakpoint="$vuetify.breakpoint.mobile ? 'md' : 'xs'">
                    <template v-slot:top>
                        <v-toolbar flat>
                            <v-row>
                                <v-col cols="8">
                                    <v-text-field
                                        v-model.number="search.name"
                                        label="Spelnamn, Platform"
                                        clearable
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="2">
                                    <v-text-field
                                        v-model.number="search.players"
                                        type="number"
                                        :min="0"
                                        label="Antal spelare"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="2">
                                    <v-text-field
                                        v-model.number="search.playtime"
                                        type="number"
                                        :min="0"
                                        label="Speltid"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-toolbar>
                    </template>
                    <template v-slot:group.header="{group,groupBy,items,headers,isOpen,toggle,remove}">
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
                        <td :colspan="headers.length" class="v-data-table__expanded v-data-table__expanded__content px-0">
                            <v-card flat tile>
                                <v-card-title>
                                    {{ item.name }}
                                    <template v-if="item.published_year">({{ item.published_year }})</template>
                                </v-card-title>
                                <v-card-text>
                                    {{ item.description }}
                                </v-card-text>
                            </v-card>
                        </td>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
import VPrintBreakpoint from "../VPrintBreakpoint";

export default {
    name: "GameList",
    components: {VPrintBreakpoint},
    created() {
        this.getGames();
    },
    data() {
        return {
            loading: true,
            headers: [
                {
                    text: 'Spel',
                    align: 'start',
                    filterable: true,
                    value: 'name',
                    width: '60%',
                    groupable: false,
                },
                {
                    text: 'Platform',
                    align: 'start',
                    filterable: true,
                    value: 'platform',
                    groupable: true,
                },
                {
                    text: 'Antal Spelare',
                    align: 'center',
                    sortable: false,
                    value: 'num_players',
                    width: '10%',
                    filter: (value, search, item) => !this.search.players || (this.search.players >= item.min_players && this.search.players <= item.max_players),
                },
                {
                    text: 'Speltid',
                    align: 'end',
                    sortable: false,
                    value: 'playtime',
                    width: '30%',
                    filter: (value, search, item) => !this.search.playtime || (this.search.playtime >= item.min_playtime && this.search.playtime <= item.max_playtime),
                }
            ],
            games: [],
            search: {
                playtime: 0,
                players: 0,
                platform: '',
                name: '',
            },
            expanded: [],
        }
    },
    methods: {
        expandRow(row) {
            this.expanded = row === this.expanded[0] ? [] : [row]
        },
        getGames() {
            axios(
                "/games?json=true",
                {
                    method:
                        'get',
                    withCredentials:
                        true,
                    responseType:
                        'json',
                    headers:
                        {
                            'Content-Type':
                                'application/json',
                            'Accept':
                                'application/json',
                        },
                }).then(res => {
                this.games = res.data;
            }).finally(() => {
                this.loading = false;
            })
        }
    }
}
</script>

<style scoped>

</style>
