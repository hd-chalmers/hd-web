<template>
    <v-container>
      <v-card v-if="error">
        <v-alert text color="error"> {{error}} </v-alert>
      </v-card>
        <v-card style="margin-bottom: 12px;" :loading="loading" elevation="7">
          <v-card-title style="margin-bottom: 5px;">
            <h2>Spellista</h2>
          </v-card-title>
          <v-card-subtitle>
            Här är några spel som är tillgängliga i våra arr
          </v-card-subtitle>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model.number="search"
                  label="Sök efter spel"
                  clearable
                  @change="$analytics.trackEvent('Games', 'Search', search)"
                >
                  <template v-slot:append> <search-icon/> </template>
                </v-text-field>
              </v-col>
              <v-col>
                <v-select label="Gruppera efter" v-model="groupBy" :items="groups" item-text="title" item-value="value" @input="$analytics.trackEvent('Games', 'Changed grouping', groupBy)">
                  <template v-slot:append> <filter-icon/> </template>
                </v-select>
              </v-col>
              <v-col>
                <v-select label="Sortera efter" v-model="sortBy" :items="sortingOptions" item-text="title" item-value="value" @input="$analytics.trackEvent('Games', 'Changed sorting', sortBy)">
                  <template v-slot:append> <align-right-icon/> </template>
                </v-select>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
                <v-data-iterator :items="games"
                              item-key="id"
                              loading-text=" "
                              :items-per-page="-1"
                              :group-by="groupBy"
                              :sort-by="sortBy"
                              :single-expand="true"
                              show-expand
                              :search="search"
                              :expanded="expanded"
                              hide-default-footer>
                  <template v-slot:default="props">
                    <v-card v-for="group in props.groupedItems" v-bind:key="group.key" style="margin-bottom: 10px;" elevation="6">
                      <v-card-text>
                      <h2 :style="`margin-bottom: 20px; color: ${$vuetify.theme.currentTheme.primary};`">
                        {{group.items[0][groupBy]}}
                        <span v-if="groupBy === 'max_players' || groupBy === 'min_players'">st</span>
                        <span v-if="groupBy === 'max_playtime' || groupBy === 'min_playtime'">min</span>
                      </h2>
                    <v-expansion-panels>
                      <v-expansion-panel v-for="item in group.items" v-bind:key="item.id" @click="clearSelect(item.id)" class="elevation-4">
                        <v-expansion-panel-header :id="'s' + item.id" style="transition: background-color 0.5s;">
                          <v-row>
                            <v-col class="text-subtitle-2" sm cols="12">
                              {{item.name}}
                            </v-col>
                            <v-col class="text-body-2 hidden-xs-only">
                              <users-icon size="1x"/>
                              {{item.min_players === item.max_players ? item.min_players :`${item.min_players}-${item.max_players}`}} spelare
                            </v-col>
                            <v-col class="text-body-2 hidden-xs-only">
                              <clock-icon size="1x"/>
                              {{item.min_playtime === item.max_playtime ? item.min_playtime :`${item.min_playtime}-${item.max_playtime}`}} min
                            </v-col>
                          </v-row>
                        </v-expansion-panel-header>
                        <v-expansion-panel-content>
                          <v-row>
                            <v-col cols="12" sm="2" v-if="item.image_link">
                              <v-img :src="item.image_link"/>
                            </v-col>
                            <v-col sm="10" cols="12" order="1" order-sm="0">{{item.description}} </v-col>
                            <v-col>
                          <v-row v-if="item.published_year || item.platform || item.genre || item.expansions.length">
                          <v-col v-if="item.expansions.length">
                            <h4><layers-icon size="1x"/> Expansioner</h4>
                            <v-chip-group>
                              <v-chip ripple v-for="expansion in item.expansions" v-bind:key="expansion.id" @click="() => {
                                goToEntry(expansion.id)
                                $analytics.trackEvent('Games', 'Expansion breadcrumb click', item.name, expansion.name)
                              }">
                                {{expansion.name}}
                              </v-chip>
                            </v-chip-group>
                          </v-col>
                            <v-col v-if="item.platform">
                              <h4><monitor-icon size="1x"/> Platform</h4>
                              {{item.platform}}
                            </v-col>
                            <v-col v-if="item.genre">
                              <h4><tag-icon size="1x"/> Genre</h4>
                              {{item.genre}}
                            </v-col>
                            <v-col v-if="item.published_year">
                              <h4><calendar-icon size="1x"/> Utgivnings år</h4>
                              {{item.published_year}}
                            </v-col>
                            <v-col class="hidden-sm-and-up">
                              <h4><users-icon size="1x"/> Antal Spelare </h4>
                              {{item.min_players === item.max_players ? item.min_players :`${item.min_players}-${item.max_players}`}}
                            </v-col>
                            <v-col class="hidden-sm-and-up">
                              <h4><clock-icon size="1x"/> Speltid</h4>
                              {{item.min_playtime === item.max_playtime ? item.min_playtime :`${item.min_playtime}-${item.max_playtime}`}} min
                            </v-col>
                            </v-row>
                            </v-col>
                            <v-col style="padding: 0" cols="12">
                              <v-btn text outlined ripple :style="$vuetify.breakpoint.xsOnly ? 'font-size: 0.7em;' : ''" style="width: 100%; margin-top: 5px;"
                                     v-if="item.expansion_to" @click="() => {
                                       goToEntry(item.expansion_to.id)
                                       $analytics.trackEvent('Games', 'Expansion to btn click', item.name, item.expansion_to.name)
                                     }">
                                <box-icon size="1.3x" style="margin-right: 3px;"/>  Expansion till {{item.expansion_to.name}}
                              </v-btn>
                            </v-col>
                          </v-row>
                        </v-expansion-panel-content>
                      </v-expansion-panel>
                    </v-expansion-panels>
                      </v-card-text>
                    </v-card>
                  </template>
                </v-data-iterator>
      <footer-card style="margin-top: 12px;" class="elevation-6"/>
    </v-container>
</template>

<script lang="ts">
//import VPrintBreakpoint from "../VPrintBreakpoint";
import {Vue, Component} from "vue-property-decorator";
import footerCard from "@/components/footerCard.vue";
import { UsersIcon, ClockIcon, CalendarIcon, LayersIcon, TagIcon, MonitorIcon, BoxIcon, FilterIcon, AlignRightIcon, SearchIcon } from "vue-feather-icons";
import {GameData} from "@/assets/ts/interfaces";

@Component({
  components: {
    footerCard,
    UsersIcon,
    ClockIcon,
    CalendarIcon,
    LayersIcon,
    TagIcon,
    MonitorIcon,
    BoxIcon,
    FilterIcon,
    AlignRightIcon,
    SearchIcon
  }
})
export default class GameList extends Vue{
    constructor() {
     super()

      performance.mark('gameLoadStart')
      this.getGames()
    }

            loading = true
            games: GameData[] = []
            search = ''
            groupBy = 'platform'
            error: string | null = null
            groups = [
              {title: 'Ogrupperad', value: ''},
              {title: 'Platform', value: 'platform'},
              {title: 'Genre', value: 'genre'},
              {title: 'Minst antal spelare', value: 'min_players'},
              {title: 'Max antal spelare', value: 'max_players'},
              {title: 'Kortast speltid', value: 'min_playtime'},
              {title: 'Längst speltid', value: 'max_playtime'},
              {title: 'Utgivnings år', value: 'published_year'}
            ]
            sortBy = 'name'
            sortingOptions = [
              {title: 'Alphabetisk Ordning', value: 'name'},
              {title: 'Platform', value: 'platform'},
              {title: 'Genre', value: 'genre'},
              {title: 'Minst antal spelare', value: 'min_players'},
              {title: 'Max antal spelare', value: 'max_players'},
              {title: 'Kortast speltid', value: 'min_playtime'},
              {title: 'Längst speltid', value: 'max_playtime'},
              {title: 'Utgivnings år', value: 'published_year'}
            ]
            expanded: number[] = []
/*
        expandRow(row?: any): number {
            console.log(row)
            return this.expanded
        }
        */
        getGames(): void {
          fetch(process.env.VUE_APP_API_URL + '/games', {
            headers:
              {
                'Content-Type':
                  'application/json',
                'Accept':
                  'application/json'
              }
          }).then(res => res.json()).then((res: GameData[]) => {
            this.games = res;
          })
            .catch(()=> this.error = "Sidan hade ett problem när den försökte hämta data från servern")
            .finally(() => {
              this.loading = false

              performance.mark('gameLoadEnd')
              performance.measure('gameLoad', 'gameLoadStart', 'gameLoadEnd')
              this.$analytics.trackTiming('API Load', 'Games', Math.round(performance.getEntriesByName('gameLoad')[0].duration))
              performance.clearMarks()
              performance.clearMeasures()
          })
        }

      goToEntry(targetId: number | bigint): void {
          const target = document.getElementById('s' + targetId) as HTMLElement
          target.style.backgroundColor = this.$vuetify.theme.currentTheme.primary + '22'
          this.$vuetify.goTo('#s' + targetId, {offset: 200});
        }

        clearSelect(targetId: number | bigint): void{
          const target = document.getElementById('s' + targetId)
          if(target?.style.backgroundColor)
          target.style.backgroundColor = ''
        }
}
</script>

<style scoped>

</style>
