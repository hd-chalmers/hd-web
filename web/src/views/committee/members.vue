<template>
    <v-container>
        <v-card>
            <v-card-text>
                <v-row>
                    <v-col cols="12" class="text-center">
                        <h1>HD {{displayedYear}}</h1>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" class="text-center">
                        <v-img lazy-src="/img/unknown_group.png" v-bind:src="groupPhoto" class="mx-auto" max-height="400px" contain></v-img>
                        {{description}}
                    </v-col>
                </v-row>
                <v-row class="mb-3 text-center justify-center">
                        <v-col v-for="member in committeeMembers" v-bind:key="member.id" cols="12" md="6" lg="4" xl="3">
                            <v-avatar size="200px" class="elevation-4 mb-2">
                                <v-img lazy-src="/img/unknown_profile.png" v-bind:src="member.profilePic" class="mx-auto" max-height="200px" contain></v-img>
                            </v-avatar>
                            <v-card elevation="1" rounded>
                                <v-card-title class="justify-center">
                                    {{member.name}}
                                </v-card-title>
                                <v-card-subtitle class="text-center">
                                    {{member.role}}
                                </v-card-subtitle>
                                <v-card-text class="py-0">
                                    <v-list class="py-0">
                                            <v-list-item v-if="member.quote" class="mx-0 py-0 text-center" style="min-height: 20px">
                                                <v-list-item-subtitle>
                                                    "{{member.quote}}"
                                                </v-list-item-subtitle>
                                            </v-list-item>
                                            <v-list-item v-if="member.description" class="mx-0 py-0 text-center" style="min-height: 20px">
                                                <v-list-item-subtitle>
                                                    {{member.description}}
                                                </v-list-item-subtitle>
                                            </v-list-item>
                                            <v-list-item  v-if="member.favouriteGame" class="mx-0 py-0 px-0 text-left" style="min-height: 20px">
                                                <v-list-item-title>
                                                    Favoritspel
                                                </v-list-item-title>
                                                <v-list-item-subtitle>
                                                    {{member.favouriteGame}}
                                                </v-list-item-subtitle>
                                            </v-list-item>
                                            <v-list-item v-if="member.favouriteSugar" class="mx-0 py-0 px-0 text-left" style="min-height: 20px">
                                                <v-list-item-title>
                                                    Favoritsocker
                                                </v-list-item-title>
                                                <v-list-item-subtitle>
                                                    {{member.favouriteSugar}}
                                                </v-list-item-subtitle>
                                            </v-list-item>
                                    </v-list>
                                </v-card-text>
                            </v-card>
                        </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-container>
</template>>

<script lang="ts">
  import {Component, Vue} from 'vue-property-decorator'
  import { memberType } from '@/assets/ts/interfaces'

  @Component
  export default class CommitteePage extends Vue{
    constructor () {
      super();
      this.getData()
    }
    displayedYear = ''
    groupPhoto = ''
    description = ''
    committeeMembers: Array<memberType> = []
    async getData(): Promise<void>{
      fetch(process.env.VUE_APP_API_URL + '/committee').then(res =>res.json()).then(res =>{
        this.displayedYear = res.displayedYear
        this.groupPhoto = res.groupPhoto
        this.description = res.description
        this.committeeMembers = res.committeeMembers
      })
    }
  }
</script>
