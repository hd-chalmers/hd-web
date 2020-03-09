<template>
    <div>
        <div class="row" v-for="(platform, i) in platforms">
            <div class="col-12">
                <h2>{{platform.name}}</h2>
                <form @submit.prevent.stop="save(platform.games)">
                    <div class="btn-group mb-1">
                        <button class="btn btn-primary" type="submit">Spara kategori</button>
                    </div>
                    <table class="table table-sm table-hover">
                        <col width="25%">
                        <col width="10%">
                        <col width="29%">
                        <col width="29%">
                        <col width="7%">
                        <thead>
                        <tr>
                            <th>
                                Namn
                            </th>
                            <th class="d-none d-md-table-cell">
                                År
                            </th>
                            <th>
                                Antal Spelare
                            </th>
                            <th>
                                Speltid
                            </th>
                            <th>

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(game, j) in platform.games"
                            :class="{'table-warning': active_transactions.includes(game.id)}">
                            <td><input type="text" class="form-control" :name="'game_name_'+game.id"
                                       :id="'game_name_'+game.id" v-model.lazy="game.name"
                                       :class="{ 'btn-outline-warning': platforms[i].games[j].name !== game.name }">
                            </td>
                            <td><input type="text" class="form-control" :name="'game_publish_year_'+game.id"
                                       :id="'game_publish_year_'+game.id" v-model.lazy="game.published_year"></td>
                            <td>
                                <div class="form-inline">
                                    <input type="text" class="col-6 form-control" :name="'game_min_players_'+game.id"
                                           :id="'game_min_players_'+game.id" v-model.lazy="game.min_players">

                                    <input type="text" class="col-6 form-control" :name="'game_max_players_'+game.id"
                                           :id="'game_max_players_'+game.id" v-model.lazy="game.max_players">
                                </div>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <input type="text" class="col-6 form-control" :name="'game_min_playtime_'+game.id"
                                           :id="'game_min_playtime_'+game.id" v-model.lazy="game.min_playtime">

                                    <input type="text" class="col-6 form-control" :name="'game_max_playtime_'+game.id"
                                           :id="'game_max_playtime_'+game.id" v-model.lazy="game.max_playtime">
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-save" @click.stop.prevent="save([game])"></i>
                                <i class="fas fa-edit"></i>
                                <i class="fas fa-trash"></i>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name   : "game-list",
        props  : {
            game_prop: {
                required: true,
                type    : Array
            }
        },
        created() {
            this.platforms = this.game_prop;
        },
        methods: {
            save(games) {
                let filt = [];
                games.forEach(game => {
                    filt.push(game.id);
                    this.active_transactions.push(game.id);
                });
                axios(
                    "/games/save",
                    {
                        data           : {games: games},
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
                    this.active_transactions = this.active_transactions.filter(function (value, index, arr) {
                        return !filt.includes(value);
                    });
                }).catch((res) => {
                    console.log(res);

                }).finally(() => {
                })
            }
        },
        data() {
            return {
                platforms          : [],
                platform           : {

                    created_at: '0000-00-00 00:00:00',
                    updated_at: '0000-00-00 00:00:00',
                    games     : [],
                    id        : 0,
                    name      : '',
                    type      : '',
                },
                active_transactions: [],
                game               : {
                    "id"              : 0,
                    "name"            : '',
                    "description"     : '',
                    "bgg_id"          : null,
                    "game_platform_id": 0,
                    "min_players"     : 0,
                    "max_players"     : 0,
                    "published_year"  : "0000",
                    "min_playtime"    : 0,
                    "max_playtime"    : 0,
                    "expansion_to"    : null,
                    "game_owner_id"   : null,
                    "created_at"      : "0000-00-00 00:00:00",
                    "updated_at"      : "0000-00-00 00:00:00"
                }
            }
        }
    }
</script>

<style scoped>

</style>
