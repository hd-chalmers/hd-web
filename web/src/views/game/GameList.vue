<template>
    <v-container>
        <v-card style="margin-bottom: 12px;" :loading="loading" elevation="6">
          <v-card-title style="margin-bottom: 5px;">
            <h2>Spel lista</h2>
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
                  append-icon="search"
                ></v-text-field>
              </v-col>
              <v-col>
                <v-select label="Gruppera efter" append-icon="filter_list" v-model="groupBy" :items="groups" item-text="title" item-value="value"/>
              </v-col>
              <v-col>
                <v-select label="Sortera efter" append-icon="sort" v-model="sortBy" :items="sortingOptions" item-text="title" item-value="value"/>
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
                    <v-card v-for="group in props.groupedItems" v-bind:key="group.key" style="margin-bottom: 10px;" elevation="4">
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
                            <v-col class="subtitle-2" sm cols="12">
                              {{item.name}}
                            </v-col>
                            <v-col class="body-2">
                              <users-icon size="1x"/>
                              {{item.min_players === item.max_players ? item.min_players :`${item.min_players}-${item.max_players}`}} spelare
                            </v-col>
                            <v-col class="body-2">
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
                            <v-col>
                          {{item.description}}
                          <v-row v-if="item.published_year || item.platform || item.genre || item.expansions.length">
                          <v-col v-if="item.expansions.length">
                            <h4><layers-icon size="1x"/> Expansioner</h4>
                            <v-chip-group>
                              <v-chip ripple v-for="expansion in item.expansions" v-bind:key="expansion.id" @click="goToEntry(expansion.id)">{{expansion.name}}</v-chip>
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
                            </v-row>
                            </v-col>
                          </v-row>
                            <v-btn text outlined ripple :style="$vuetify.breakpoint.xsOnly ? 'font-size: 0.7em;' : ''" style="width: 100%; margin-top: 5px;"
                                   v-if="item.expansion_to" @click="goToEntry(item.expansion_to.id)">
                              <box-icon size="1.3x" style="margin-right: 3px;"/>  Expansion till {{item.expansion_to.name}}
                            </v-btn>
                        </v-expansion-panel-content>
                      </v-expansion-panel>
                    </v-expansion-panels>
                      </v-card-text>
                    </v-card>
                  </template>>
                </v-data-iterator>
      <footer-card style="margin-top: 12px;"/>
    </v-container>
</template>

<script lang="ts">
//import VPrintBreakpoint from "../VPrintBreakpoint";
import {Vue, Component} from "vue-property-decorator";
import footerCard from "@/components/footerCard.vue";
import { UsersIcon, ClockIcon, CalendarIcon, LayersIcon, TagIcon, MonitorIcon, BoxIcon } from "vue-feather-icons";

@Component({
  components: {
    footerCard,
    UsersIcon,
    ClockIcon,
    CalendarIcon,
    LayersIcon,
    TagIcon,
    MonitorIcon,
    BoxIcon
  }
})
export default class GameList extends Vue{
    constructor() {
        super()
        this.getGames()
    }

            loading = true
            games: any[] = []
            search = ''
            groupBy = 'platform'
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
          }).then(res => res.json()).then(res => {
            this.games = res;
          }).finally(() => {
            this.loading = false;
          })
        }

      goToEntry(targetId: number): void {
          const target = document.getElementById('s' + targetId) as HTMLElement
          target.style.backgroundColor = this.$vuetify.theme.currentTheme.primary + '22'
          this.$vuetify.goTo('#s' + targetId, {offset: 200});
        }

        clearSelect(targetId: number): void{
          const target = document.getElementById('s' + targetId)
          if(target?.style.backgroundColor)
          target.style.backgroundColor = ''
        }
}
</script>

<style scoped>

</style>
