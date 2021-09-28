<template>
  <v-data-table
    :headers="headers"
    :items="games"
    item-key="id"
    dense
    group-by="group"
    :items-per-page="-1"
    show-expand
    single-expand
  >
    <template v-slot:item.updated_at="{item}">{{new Date(item.updated_at).toLocaleString('sv')}}</template>
    <template v-slot:item.created_at="{item}">{{new Date(item.created_at).toLocaleString('sv')}}</template>
    <template v-slot:group.header="
      /* eslint-disable-next-line vue/no-unused-vars */
      {group,groupBy,items,headers,isOpen,toggle,remove}
    ">
      <td :colspan="headers.length" @click="toggle">
        <v-btn small icon v-if="isOpen" style="background-color: transparent">
          <v-icon>mdi-menu-up</v-icon>
        </v-btn>
        <v-btn small icon v-else>
          <v-icon>mdi-menu-down</v-icon>
        </v-btn>
        {{ group.trim() }}
      </td>
    </template>
    <template v-slot:expanded-item="{ headers, item }">
      <td :colspan="headers.length" class="v-data-table__expanded v-data-table__expanded__content px-0" style="margin: 10px;">
        <v-card tile flat>
          <v-alert v-if="error['s' + item.id]" color="error" text>{{error['s' + item.id]}}</v-alert>
          <v-card-text>
            <v-row>
              <v-col cols="12" style="padding: 0;">
                <v-btn outlined rounded color="blue" x-small @click="searchBoardgameAtlas(item)" :loading="loading['atlas-s' + item.id]">
                  <search-icon size="1x" style="margin-right: 5px;"/>
                  Sök i Boardgame Atlas
                </v-btn>
                <v-fade-transition>
                  <v-select v-if="searchResults[0]" v-model="searchSelect" :items="searchResults" item-text="name" return-object @input="fillEntry(item)"
                            label="Sökresultat" style="display: inline-block; margin: 10px;" dense/>
                </v-fade-transition>
              </v-col>
              <v-col>
                <v-text-field label="namn" v-model="item.name" :messages="messages['name-s' + item.id]" style="min-width: 100px;"/>
              </v-col>
              <v-col>
                <v-text-field label="utgivnings år" v-model="item.published_year" type="number" style="min-width: 100px;"/>
              </v-col>
              <v-col>
                <v-text-field label="max antal spelare" v-model="item.max_players" type="number" suffix="st" style="min-width: 100px;"/>
              </v-col>
              <v-col>
                <v-text-field label="minst antal spelare" v-model="item.min_players" type="number" suffix="st" style="min-width: 100px;"/>
              </v-col>
              <v-col>
                <v-text-field label="Längsta speltid" v-model="item.max_playtime" type="number" suffix="min" style="min-width: 100px;"/>
              </v-col>
              <v-col>
                <v-text-field label="Kortaste speltid" v-model="item.min_playtime" type="number" suffix="min" style="min-width: 100px;"/>
              </v-col>
              <v-col cols="12">
                <v-textarea label="beskrivning" v-model="item.description" dense/>
              </v-col>
              <v-col>
                <v-autocomplete label="expansion till" v-model="item.expansion_to" :items="games" item-text="name" item-value="id" style="min-width: 100px;"
                                clearable :error-messages="error['expansion-s' + item.id]" @input="error['expansion-s' + item.id] = undefined"/>
              </v-col>
              <v-col>
                <v-autocomplete label="genre" v-model="item.genre" item-text="name" item-value="id" :items="genres" style="min-width: 100px;"
                                clearable :error-messages="error['genre-s' + item.id]" @input="error['genre-s' + item.id] = undefined"/>
                <v-expand-transition>
                <v-card v-if="item.genre === -1" elevation="2">
                  <v-form @submit.prevent="">
                  <v-text-field style="display: inline-block; width: 80%; box-sizing: border-box; padding-left: 5px;"
                                label="Ny genre namn" v-model="newCategories['genre-s' + item.id]"/>
                  <v-btn color="success" style="width: 20%; font-size: 0.6em; min-width: 0;" text>Lägg till</v-btn>
                  </v-form>
                </v-card>
                </v-expand-transition>
              </v-col>
              <v-col>
                <v-autocomplete label="platform" v-model="item.platform" item-text="name" item-value="id" :items="platforms" style="min-width: 100px;"
                                clearable :error-messages="error['platform-s'+ item.id]" @input="error['platform-s'+ item.id] = undefined"/>
                <v-expand-transition>
                <v-card v-if="item.platform === -1" elevation="2">
                  <v-form @submit.prevent="">
                    <v-text-field style="display: inline-block; width: 80%; box-sizing: border-box; padding-left: 5px;"
                                  label="Ny platform namn" v-model="newCategories['platform-s' + item.id]"/>
                    <v-btn color="success" style="width: 20%; font-size: 0.6em; min-width: 0;" text>Lägg till</v-btn>
                  </v-form>
                </v-card>
                </v-expand-transition>
              </v-col>
              <v-col>
                <v-text-field label="Bild Länk" v-model="item.image_link" type="link" style="min-width: 100px;"/>
              </v-col>
              <v-col cols="12">
                <v-expansion-panels>
                  <v-expansion-panel>
                    <v-expansion-panel-header>{{item.owner.name? 'Ägare: ' + item.owner.name : 'Ingen ägare'}}</v-expansion-panel-header>
                    <v-expansion-panel-content>
                      <v-row>
                        <v-col>
                          <v-autocomplete label="Ägare" v-model="item.owner" item-text="name" item-value="id" :items="owners" clearable
                                          return-object style="min-width: 100px;"/>
                          <v-card v-if="item.owner.id === -1" elevation="2">
                            <v-form @submit.prevent="">
                              <v-text-field style="display: inline-block; width: 80%; box-sizing: border-box; padding-left: 5px;"
                                            label="Ägarens namn" v-model="newCategories['owner-s' + item.id]"/>
                              <v-btn color="success" style="width: 20%; font-size: 0.6em; min-width: 0;" text>Lägg till</v-btn>
                            </v-form>
                          </v-card>
                        </v-col>
                        <v-col>
                          <v-text-field label="Smeknamn" v-model="item.owner.nickname" style="min-width: 100px;"/>
                        </v-col>
                        <v-col>
                          <v-text-field label="Telefon nr" v-model="item.owner.phone_number" style="min-width: 100px;"/>
                        </v-col>
                        <v-col>
                          <v-text-field label="E-mejl" v-model="item.owner.email" style="min-width: 100px;"/>
                        </v-col>
                      </v-row>
                    </v-expansion-panel-content>
                  </v-expansion-panel>
                </v-expansion-panels>
              </v-col>
              <v-col cols="12">
                <v-btn color="success">Spara</v-btn>
                <span></span>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </td>
    </template>
  </v-data-table>
</template>

<script lang="ts">
import { Component, Vue} from "vue-property-decorator"
import {SearchIcon} from "vue-feather-icons";

@Component({
  components: { SearchIcon }
})
export default class Games extends Vue{
  constructor() {
    super()
    this.getData()
  }
  games: any[] = []
  genres: any[] = []
  platforms: any[] = []
  owners: any[] = []
  headers: any[] = [
    {text: 'Namn', value: 'name', align: 'start', groupable: false },
    {text: 'Utgivnings år', value: 'published_year', align: 'center', groupable: true},
    {text: 'Senast updaterad', value: 'updated_at', align: 'center', groupable: false},
    {text: 'Skapad', value: 'created_at', align: 'right', groupable: false}
  ]
  loading: any = []
  error: any = []
  messages: any = []
  newCategories: any = []
  searchResults: any[] = []
  searchSelect: any = {}
  mechanicsList: any[] = []

  getData(): void{
    fetch(process.env.VUE_APP_API_URL + '/loehk/games')
      .then(res => res.json()).then(res => {
        this.games = res.games
        this.genres = res.genres
        this.platforms = res.platforms
        this.owners = res.owners

        this.genres.unshift({id: -1, name: 'Lägg till en genre'})
        this.platforms.unshift({id: -1, name: 'Lägg till en platform'})
        this.owners.unshift({id: -1, name: 'Lägg till en ägare'})
    })
  }

  searchBoardgameAtlas(item: any): void{
    console.log('click')
    this.error = []
    this.$set(this.loading,'atlas-s' + item.id, true)
    fetch('https://api.boardgameatlas.com/api/search?client_id=E23Rb2sc1L&limit=6&name=' + item.name)
      .then(res => res.json()).then(res => {
        console.log(res.games[0])
        if(res.games[0] === undefined){
          this.error['s' + item.id] = 'Kunde inte hitta spelet i Boardgame Atlas'
          console.log('fail')
          return
        }
        this.searchResults = res.games
        this.searchSelect = this.searchResults[0]

        if(this.mechanicsList[0]){
          this.fillEntry(item)
        }
        else {
          fetch('https://api.boardgameatlas.com/api/game/mechanics?client_id=E23Rb2sc1L')
            .then(res => res.json()).then(res => {
              this.mechanicsList = res.mechanics
              this.fillEntry(item)
          })
        }
    })
    .finally(() => {
      console.log('finally')
      this.$set(this.loading, 'atlas-s' + item.id, false)
    })
  }

  fillEntry(item: any): void{
    this.error = []
    item.description = this.searchSelect.description_preview
    item.published_year = this.searchSelect.year_published
    item.min_players = this.searchSelect.min_players
    item.max_players = this.searchSelect.max_players
    item.min_playtime = this.searchSelect.min_playtime
    item.max_playtime = this.searchSelect.max_playtime
    item.image_link = this.searchSelect.image_url

    this.error['platform-s' + item.id] = "Troligtvis brädspel"

    if(this.searchSelect.mechanics[0]) {
      this.error['genre-s' + item.id] = ''
      for (const source of this.searchSelect.mechanics) {
        for (const mechanic of this.mechanicsList) {
          if (mechanic.id === source.id) {
            this.error['genre-s' + item.id] += mechanic.name + ', '
            break
          }
        }
      }
    }
    if(this.searchSelect.type === "expansion"){
      this.error['expansion-s' + item.id] = 'Är en expansion!'
    }
    this.messages['name-s' + item.id] = this.searchSelect.name
  }

}
</script>
