<template>
    <div>
        <div class="row">
            <div class="col-12 text-center">
                <h1>Skapa nytt spel</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3>
                    Sök efter spel
                </h3>
            </div>
        </div>
        <form @submit.prevent.stop="search" class="form-inline">
            <input type="text" id="search_name" name="search_name" class="form-control mr-1" v-model="search_form.query"
                   required placeholder="Namn att söka på">
            <select class="custom-select mr-1" id="search_category" required v-model="search_form.type">
                <option value="all">Alla</option>
                <option value="boardgame">Brädspel</option>
                <option value="boardgamexpansion">Brädspel - Expansion</option>
                <option value="videogame">TV/Datorspel</option>
            </select>
            <div class="form-check mb-2 mr-sm-2">
                <input class="form-check-input" type="checkbox" value="1" v-model="search_form.exact"
                       id="inlineFormCheck">
                <label class="form-check-label" for="inlineFormCheck">
                    Exakt Sökning
                </label>
            </div>
            <button id="serch_button" style="bottom: 0" class="btn btn-info" :disabled="search_running">Sök</button>
        </form>
        <span style="text-decoration: underline; cursor:pointer;" @click="show_results = !show_results"
              v-if="search_results.length">
            <span v-if="show_results">Dölj</span><span v-else>Visa</span> resultat ({{search_results.length}})
        </span>
        <span v-else-if="search_run">Inga resultat</span>
        <div class="table-wrapper-scroll-y my-custom-scrollbar border-bottom border-top"
             v-if="show_results && search_results.length">
            <table class="table table-sm table-hover table-borderless">
                <thead>
                <tr>
                    <th>Klicka för att hämta data</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="search_result in search_results" @click="select_result(search_result.id)"
                    v-bind:key="search_result.id" style="cursor:pointer;">
                    <td>
                        {{search_result.published_year}} - {{search_result.name}}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <form @submit.prevent.stop="search">
            <hr>
            <div class="form-row">
                <div class="col-6">
                    <label for="category">Kategori <span style="color: red">*</span></label>
                    <select class="custom-select" id="category" required v-model="game.game_platform_id">
                        <option selected disabled value="0">Välj Kategori</option>
                        <option v-for="category in platforms" :value="category.id" v-bind:key="category.id">{{category.name}}</option>
                    </select>
                </div>
                <div class="col-6">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" v-model="expansion">
                        <label class="form-check-label" for="inlineCheckbox1">Expansion</label>
                    </div>
                    <template v-if="expansion">
                        <label for="expansion_to">Expansion Till</label>
                        <select class="custom-select" id="expansion_to" required v-model="game.expansion_to">
                            <option selected disabled value="0">Välj Spel</option>
                        </select>
                    </template>
                </div>
            </div>
            <div class="form-row">
                <div class="col-6">
                    <label for="name">Namn</label>
                    <input class="form-control" type="text" id="name" v-model="game.name" required>
                </div>
                <div class="col-3">
                    <label for="min_players">Spelare min</label>
                    <input class="form-control" type="number" min="0" v-model.number="game.min_players" id="min_players">
                </div>
                <div class="col-3">
                    <label for="max_players">Spelare max</label>
                    <input class="form-control" type="number" min="0" v-model.number="game.max_players" id="max_players">
                </div>
            </div>
            <div class="form-row">
                <div class="col-6">
                    <label for="published_year">Release år</label>
                    <input class="form-control" type="number" id="published_year" v-model="game.published_year" required>
                </div>
                <div class="col-3">
                    <label for="min_playtime">Speltid min (Minuter)</label>
                    <input class="form-control" type="number" min="0" v-model.number="game.min_playtime" id="min_playtime">
                </div>
                <div class="col-3">
                    <label for="max_playtime">Speltid max (Minuter)</label>
                    <input class="form-control" type="number" min="0" v-model.number="game.max_playtime" id="max_playtime">
                </div>
            </div>
            <div class="form-row">
                <div class="col-12">
                    <label for="description">Beskrivning</label>

                </div>
            </div>
        </form>
    </div>
</template>

<script>

    //import { Editor, EditorContent } from 'tiptap'

    export default {
        components: {
        },
        name   : "create-game",
        methods: {
            matchPlatform(name) {
                return this.platforms.find(function (platform, index) {
                    if (platform.bgg_type === name) {
                        return true;
                    }
                });
            },
            select_result(id) {
                if (!this.fetch_running) {
                    this.fetch_running = true;
                    this.$snotify.async(
                        '',
                        'Hämtar data',
                        () => {
                            return new Promise((success, fail) => {
                              /*
                                axios(
                                    "/bgg/fetch/" + id,
                                    {
                                        method         : 'post',
                                        withCredentials: true,
                                        responseType   : 'json',
                                        headers        :
                                            {
                                                'Content-Type':
                                                    'application/json',
                                                'Accept'      :
                                                    'application/json',
                                            },
                                    }).then(res => {
                                    success({
                                        title : '',
                                        body  : 'Klar!',
                                        config: {
                                            closeOnClick   : true,
                                            showProgressBar: true
                                        }
                                    });
                                    this.game.bgg_id         = id;
                                    this.game.name           = res.data.name[0]['@attributes']['value'];
                                    this.game.min_players    = parseInt(res.data.minplayers['@attributes']['value']);
                                    this.game.max_players    = parseInt(res.data.maxplayers['@attributes']['value']);
                                    this.game.published_year = res.data.yearpublished['@attributes']['value'];
                                    this.game.min_playtime   = parseInt(res.data.minplaytime['@attributes']['value']);
                                    this.game.max_playtime   = parseInt(res.data.maxplaytime['@attributes']['value']);
                                    this.game.description    = res.data.description;
                                    console.log(this.matchPlatform(res.data['@attributes']['type']));
                                    this.game.game_platform_id = this.matchPlatform(res.data['@attributes']['type']).id;
                                    this.show_results          = false;
                                }).catch((res) => {
                                    fail({
                                        title : 'Ett fel inträffade',
                                        body  : 'WTF??',
                                        config:
                                            {
                                                titleMaxLength: 30,
                                                closeOnClick  : true,
                                            }
                                    });
                                }).finally(() => {
                                    this.fetch_running = false;
                                })*/
                            });
                        }
                    );
                }
            },
          // eslint-disable-next-line @typescript-eslint/no-empty-function
            submit() {

            },
            search() {
                if (!this.search_running) {
                    this.search_running = true;
                    this.$snotify.async(
                        '',
                        'Söker',
                        () => {
                            return new Promise((success, fail) => {
                              /*
                                axios(
                                    "/bgg/search",
                                    {
                                        data           : JSON.stringify(this.search_form),
                                        method         : 'post',
                                        withCredentials: true,
                                        responseType   : 'json',
                                        headers        :
                                            {
                                                'Content-Type':
                                                    'application/json',
                                                'Accept'      :
                                                    'application/json',
                                            },
                                    }).then(res => {
                                    success({
                                        title : '',
                                        body  : 'Klar!',
                                        config: {
                                            closeOnClick   : true,
                                            showProgressBar: true
                                        }
                                    });
                                    this.search_results = res.data.items;
                                }).catch((res) => {
                                    fail({
                                        title : 'Ett fel inträffade',
                                        body  : res.data.message,
                                        config:
                                            {
                                                titleMaxLength: 30,
                                                closeOnClick  : true,
                                            }
                                    });
                                }).finally(() => {
                                    this.search_running = false;
                                    this.search_run     = true;
                                })*/
                            });
                        }
                    );
                }
            }
        },
        props  : {
            platforms: {
                required: true,
                type    : Array,
            }
        },
        data() {
            return {
                search_run    : false,
                search_running: false,
                show_results  : false,
                expansion     : false,
                game          : {
                    game_platform_id: 0,
                    name            : '',
                    description     : '',
                    bgg_id          : 0,
                    min_players     : 0,
                    max_players     : 0,
                    published_year  : 2020,
                    min_playtime    : 0,
                    max_playtime    : 0,
                    expansion_to    : 0,
                    game_owner_id   : 0,
                },
                game_owner    : {
                    name       : '',
                    nickname   : '',
                    phonenumber: '',
                    email      : '',
                },
                search_form   : {
                    type : 'boardgame',
                    query: '',
                    exact: 0,
                },
                search_result : {
                    type          : '',
                    name          : '',
                    published_year: '0000',
                    id            : -1
                },
                search_results: [],
            }
        }
    }
</script>

<style scoped>
    .my-custom-scrollbar {
        position: relative;
        max-height: 200px;
        overflow: auto;
    }

    .table-wrapper-scroll-y {
        display: block;
    }
</style>
