<template>
    <v-container>
      <v-card>
        <v-alert v-if="error" text color="error"> {{error}} </v-alert>
      </v-card>

      <v-row dense>
        <!-- Committee photo and description -->
        <v-col cols="12" sm="5" xl="4">
          <v-card elevation="7">
            <v-img lazy-src="/img/unknown_group.webp" v-bind:src="groupPhoto ? groupPhoto : '/img/unknown_group.webp'" class="mx-auto" contain></v-img>
          </v-card>
        </v-col>
        <v-col align-self="stretch" cols="12" sm="7" xl="8">
          <v-card class="text-center" style="height: 100%" elevation="7">
                <v-card-title style="margin: auto; display: inline-block">
                  HD {{displayedYear}}
                </v-card-title>
            <v-card-text style="height: 60%; margin-bottom: 5px;">
            <v-card style="height: 100%" elevation="5">
              <v-card-text>
                <v-progress-circular v-if="loading" indeterminate color="primary" style="width: 100%; margin: 5px;"></v-progress-circular>
                {{description}}
              </v-card-text>
            </v-card>
            </v-card-text>
          </v-card>
        </v-col>

        <!-- Loop through all the committee members -->
        <v-col v-for="member in committeeMembers" v-bind:key="member.id" cols="12" sm="6" lg="4" xl="3" align-self="stretch">
          <v-card style="height: 100%;" elevation="6">
            <v-card-text style="height: 100%;">
              <v-row dense class="align-center" style="height: 100%;">

                <!-- Committee member photo -->
                <v-col cols="12" sm="4" align-self="center">
                  <v-avatar :width="$vuetify.breakpoint.xsOnly ? '150px' :'100%'" :height="$vuetify.breakpoint.xsOnly ? '150px' : 'inherit'" style="margin: auto; display: block;" class="elevation-4 mb-2">
                    <v-img lazy-src="/img/unknown_profile.webp" v-bind:src="member.image ? member.image : '/img/unknown_profile.webp'" class="mx-auto" max-height="200px" contain></v-img>
                  </v-avatar>
                </v-col>

                <!-- Committee member name and position ++ -->
                <v-col sm="8" cols="12" align-self="stretch">
                  <v-card elevation="5" rounded style="height: 100%;">
                    <v-card-title class="justify-center">
                      {{member.name}}
                    </v-card-title>
                    <v-card-subtitle class="text-center">
                      {{member.role}}
                    </v-card-subtitle>
                    <v-card-text>
                      <v-row>
                        <v-col cols="12" v-if="member.quote" class="mx-0 py-0 text-center" style="min-height: 20px;">
                            "{{member.quote}}"
                        </v-col>
                        <v-col cols="12" v-if="member.description" class="mx-0 py-0 text-center" style="min-height: 20px">
                            {{member.description}}
                        </v-col>
                        <template v-if="member.favourite_game" class="mx-0 py-0 px-0 text-left" style="min-height: 20px">
                          <v-col>
                          <span class="text-subtitle-2" style="margin-right: 5px;">
                            Favoritspel:
                          </span>
                            {{ member.favourite_game }}
                          </v-col>
                        </template>
                        <template v-if="member.favourite_sugar" class="mx-0 py-0 px-0 text-left" style="min-height: 20px">
                          <v-col class="flex-nowrap">
                          <span class="text-subtitle-2" style="margin-right: 5px;">
                            Favoritsocker:
                          </span>
                            {{ member.favourite_sugar }}
                          </v-col>
                        </template>
                      </v-row>
                    </v-card-text>
                  </v-card>
                </v-col>

              </v-row>
            </v-card-text>
          </v-card>
        </v-col>

        <template v-if="loading">
          <v-col cols="12" sm="6" lg="4" xl="3">
          <v-card>
              <v-card-text>
                    <v-skeleton-loader type="card" :style="`width: 100%; margin: 5px`"></v-skeleton-loader>
              </v-card-text>
          </v-card>
          </v-col>
          <v-col cols="12" sm="6" lg="4" xl="3">
            <v-card>
              <v-card-text>
                <v-skeleton-loader type="card" :style="`width: 100%; margin: 5px`"></v-skeleton-loader>
              </v-card-text>
            </v-card>
          </v-col>
          <v-col cols="12" sm="6" lg="4" xl="3">
            <v-card>
              <v-card-text>
                <v-skeleton-loader type="card" :style="`width: 100%; margin: 5px`"></v-skeleton-loader>
              </v-card-text>
            </v-card>
          </v-col>
          <v-col cols="12" sm="6" lg="4" xl="3">
            <v-card>
              <v-card-text>
                <v-skeleton-loader type="card" :style="`width: 100%; margin: 5px`"></v-skeleton-loader>
              </v-card-text>
            </v-card>
          </v-col>
        </template>


        <v-col align-self="stretch">
          <footer-card style="height: 100%;" class="elevation-6"/>
        </v-col>

      </v-row>
    </v-container>
</template>>

<script lang="ts">
  import {Component, Vue} from 'vue-property-decorator'
  import {MemberType, YearData} from '@/assets/interfaces'
  import footerCard from '@/components/common/footerCard.vue'

  /**
   * A page that shows information about the committee members.
   */
  @Component({
    components: {
      footerCard
    }
  })
  export default class CommitteePage extends Vue{

    /**
     * A constructor for the committee page which starts the loading of the data.
     */
    mounted() {
      performance.mark('committeeLoadStart')
      this.getData()
    }

    // The year string for the current year.
    displayedYear = ''
    // The url to the group image.
    groupPhoto: string | null = ''
    // the description of the group.
    description: string | null = ''
    // The member data of the committee.
    committeeMembers: MemberType[] = []
    // Loading state of the page.
    loading = true
    // Error message for when the data could not be loaded.
    error = ''

    /**
     * Gets the data from the server such as the committee members array and the group photo.
     * @public
     */
    async getData(): Promise<void>{
      this.loading = true
      fetch(process.env.NUXT_ENV_API_URL + '/committee').then(res =>res.json()).then((res: YearData) =>{
        this.error = ''
        this.displayedYear = res.displayed_year
        this.groupPhoto = res.groupPhoto
        this.description = res.description
        this.committeeMembers = res.committee_members
      })
      .catch((err: Error) => {
        this.error = 'Sidan kunde inte nå servern'
        this.$ga.exception('Committee ' + err.message)
        setTimeout(() => this.getData(), 5000)
      })
      .finally(() => {
        this.loading = false

        performance.mark('committeeLoadEnd')
        performance.measure('committeeLoad', 'committeeLoadStart', 'committeeLoadEnd')
        this.$ga.time('API Load', 'Committee Members', Math.round(performance.getEntriesByName('committeeLoad')[0].duration))
        performance.clearMarks()
        performance.clearMeasures()
      })
    }
  }
</script>
