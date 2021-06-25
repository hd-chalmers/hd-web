<template>
    <div>
        <v-navigation-drawer v-model="nav" app :temporary="$vuetify.breakpoint.mobile">
            <v-list>
                <v-list-item-group>
                    <v-list-item to="/loehk">
                        <v-list-item-icon>
                            <v-icon>
                                mdi-home
                            </v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            Loehk
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to="/loehk/active-year">
                        <v-list-item-icon>
                            <v-icon>
                                mdi-image
                            </v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            Sittande
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to="/loehk/events">
                        <v-list-item-icon>
                            <v-icon>
                                mdi-calendar
                            </v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            Events
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to="/loehk/investments">
                        <v-list-item-icon>
                            <v-icon>
                                mdi-playlist-edit
                            </v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            Strecklista
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to="/loehk/prices">
                        <v-list-item-icon>
                            <v-icon>
                                mdi-playlist-edit
                            </v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            Prislista
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to="/loehk/games">
                        <v-list-item-icon>
                            <v-icon>
                                mdi-playlist-edit
                            </v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            Spel
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
            <template v-slot:append>
                <div class="pa-2">
                    <v-btn block color="purple" dark>Logout</v-btn>
                </div>
            </template>
        </v-navigation-drawer>
        <v-main>
            <v-container fluid>
                <v-card>
                    <v-card-title>
                        <v-btn icon @click.stop="nav = !nav">
                            <v-icon>
                                mdi-menu
                            </v-icon>
                        </v-btn>
                        Loehk
                    </v-card-title>
                    <v-card-text>
                        <router-view></router-view>
                    </v-card-text>
                </v-card>
            </v-container>
        </v-main>
    </div>
</template>

<script>
export default {
    name: "LoehkMain",
    data() {
        return {
            nav: null,
        }
    }
}
</script>

<style scoped>

</style>
