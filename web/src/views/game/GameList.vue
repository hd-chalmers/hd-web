<template>
    <v-container>
        <v-card>
          <v-card-title style="margin-bottom: 5px;">
            <h2>Spelista</h2>
          </v-card-title>
          <v-card-subtitle>
            Här är några spel som är tillgänliga i våra arr
          </v-card-subtitle>
            <v-card-text>
                <v-data-iterator :items="games"
                              item-key="id"
                              :loading="loading"
                              loading-text="Hämtar våra spel..."
                              :items-per-page="-1"
                              :group-by="groupBy"
                              :sort-by="sortBy"
                              :single-expand="true"
                              show-expand
                              :search="search"
                              :expanded="expanded">
                    <template v-slot:header>
                            <v-row>
                                <v-col cols="12" sm="6">
                                    <v-text-field
                                        v-model.number="search"
                                        label="Sök efter spel"
                                        clearable
                                    ></v-text-field>
                                </v-col>
                              <v-col>
                                <v-select label="Gruppera efter" v-model="groupBy" :items="groups" item-text="title" item-value="value"/>
                              </v-col>
                              <v-col>
                                <v-select label="Sortera efter" v-model="sortBy" :items="sortingOptions" item-text="title" item-value="value"/>
                              </v-col>
                            </v-row>
                    </template>
                  <template v-slot:default="props">
                    <div v-for="group in props.groupedItems" v-bind:key="group.key" style="margin-bottom: 10px;">
                      <h2 :style="`margin: 20px 0; color: ${$vuetify.theme.currentTheme.primary};`">
                        {{group.items[0][groupBy]}}
                        <span v-if="groupBy === 'max_players' || groupBy === 'min_players'">st</span>
                        <span v-if="groupBy === 'max_playtime' || groupBy === 'min_playtime'">min</span>
                      </h2>
                    <v-expansion-panels>
                      <v-expansion-panel v-for="item in group.items" v-bind:key="item.id" :id="'s' + item.id">
                        <v-expansion-panel-header>
                          <v-row>
                            <v-col class="subtitle-2" sm cols="12">
                              {{item.name}}
                            </v-col>
                            <v-col class="body-2">
                              {{item.min_players === item.max_players ? item.min_players :`${item.min_players}-${item.max_players}`}} spelare
                            </v-col>
                            <v-col class="body-2">
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
                          <v-row v-if="item.platform || item.expansions">
                          <v-col v-if="item.expansions">
                            <h4>Expansioner</h4>
                            <v-chip-group>
                              <v-chip v-for="expansion in item.expansions" v-bind:key="expansion.id" @click="$vuetify.goTo('#s' + expansion.id)">{{expansion.name}}</v-chip>
                            </v-chip-group>
                          </v-col>
                            <v-col v-if="item.platform">
                              <h4>Platform</h4>
                              {{item.platform}}
                            </v-col>
                            <v-col v-if="item.genre">
                              <h4>Genre</h4>
                              {{item.genre}}
                            </v-col>
                            <v-col v-if="item.published_year">
                              <h4>Utgivnings år</h4>
                              {{item.published_year}}
                            </v-col>
                            </v-row>
                            </v-col>
                          </v-row>
                            <v-btn text outlined :style="$vuetify.breakpoint.xsOnly ? 'font-size: 0.7em;' : ''" v-if="item.expansion_to" @click="$vuetify.goTo('#s' + item.expansion_to.id)" style="width: 100%; margin-top: 5px;">
                              Expansion till {{item.expansion_to.name}}
                            </v-btn>
                        </v-expansion-panel-content>
                      </v-expansion-panel>
                    </v-expansion-panels>
                    </div>
                  </template>
                </v-data-iterator>
            </v-card-text>
        </v-card>
      <footer-card style="margin-top: 12px;"/>
    </v-container>
</template>

<script lang="ts">
//import VPrintBreakpoint from "../VPrintBreakpoint";
import {Vue, Component} from "vue-property-decorator";
import footerCard from "@/components/footerCard.vue";

@Component({
  components: {
    footerCard
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
              {title: 'Minimum speltid', value: 'min_playtime'},
              {title: 'Max speltid', value: 'max_playtime'},
              {title: 'Utgivnings år', value: 'published_year'}
            ]
            sortBy = 'name'
            sortingOptions = [
              {title: 'Alphabetisk Ordning', value: 'name'},
              {title: 'Platform', value: 'platform'},
              {title: 'Genre', value: 'genre'},
              {title: 'Minst antal spelare', value: 'min_players'},
              {title: 'Max antal spelare', value: 'max_players'},
              {title: 'Minimum speltid', value: 'min_playtime'},
              {title: 'Max speltid', value: 'max_playtime'},
              {title: 'Utgivnings år', value: 'published_year'}
            ]
            expanded: boolean[] = []

        expandRow(row: any): void {
            this.expanded = row === this.expanded[0] ? [] : [row]
        }
        getGames(): void {
          fetch(process.env.VUE_APP_API_URL + '/games', {
            headers:
              {
                'Content-Type':
                  'application/json',
                'Accept':
                  'application/json',
                sessionId: ''
              }
          }).then(res => res.json()).then(res => {
            this.games = res;
          }).finally(() => {
            this.loading = false;
          })
        }
}
</script>

<style scoped>

</style>
