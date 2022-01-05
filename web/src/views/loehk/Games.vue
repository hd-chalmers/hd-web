<template>
  <v-data-table
    :headers="$vuetify.breakpoint.xs ? [headers[0]] :headers"
    :items="games"
    item-key="id"
    dense
    group-by="group"
    :items-per-page="-1"
    show-expand
    single-expand
    sort-by="name"
    must-sort
    :loading="pageLoading"
  >
    <template v-slot:item.updated_at="{item}">{{new Date(item.updated_at).toLocaleString('sv')}}</template>
    <template v-slot:item.created_at="{item}">{{new Date(item.created_at).toLocaleString('sv')}}</template>
    <template v-slot:top>
      <v-expansion-panels>
        <v-expansion-panel>
          <v-expansion-panel-header> Nytt Spel</v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-card tile flat>
              <v-alert v-if="error['s' + newGame.id]" color="error" text>{{error['s' + newGame.id]}}</v-alert>
              <v-card-text>
                <v-row>
                  <v-col cols="11" style="padding: 0;">
                    <v-btn outlined rounded color="blue" small @click="searchBoardgameAtlas(newGame)" :loading="loading['atlas-s' + newGame.id]">
                      <search-icon size="1x" style="margin-right: 5px;"/>
                      Sök i Boardgame Atlas
                    </v-btn>
                    <v-fade-transition>
                      <v-select v-if="searchResults[0]" v-model="searchSelect" :items="searchResults" item-text="name" return-object @input="fillEntry(newGame)"
                                label="Sökresultat" style="display: inline-block; margin: 10px;" dense/>
                    </v-fade-transition>
                  </v-col>
                  <v-form @submit.prevent="insertGame(newGame)" v-model="valid[newGame.id]">
                    <v-row>
                      <v-col>
                        <v-text-field label="namn" v-model="newGame.name" :messages="messages['name-s' + newGame.id]" :rules="[rules.notEmpty]" persistent-hint hint="Krävs"  style="min-width: 100px;"/>
                      </v-col>
                      <v-col>
                        <v-text-field label="utgivnings år" v-model="newGame.published_year" type="number" style="min-width: 100px;"/>
                      </v-col>
                      <v-col>
                        <v-text-field label="max antal spelare" v-model="newGame.max_players" type="number" suffix="st" style="min-width: 100px;"/>
                      </v-col>
                      <v-col>
                        <v-text-field label="minst antal spelare" v-model="newGame.min_players" type="number" suffix="st" style="min-width: 100px;"/>
                      </v-col>
                      <v-col>
                        <v-text-field label="Längsta speltid" v-model="newGame.max_playtime" type="number" suffix="min" style="min-width: 100px;"/>
                      </v-col>
                      <v-col>
                        <v-text-field label="Kortaste speltid" v-model="newGame.min_playtime" type="number" suffix="min" style="min-width: 100px;"/>
                      </v-col>
                      <v-col cols="12">
                        <v-textarea label="beskrivning" v-model="newGame.description" dense outlined/>
                      </v-col>
                      <v-col>
                        <v-autocomplete label="expansion till" v-model="newGame.expansion_to" :items="games" item-text="name" item-value="id" style="min-width: 100px;"
                                        clearable :error-messages="error['expansion-s' + newGame.id]"
                                        @input="() => { error['expansion-s' + newGame.id] = undefined;  newGame.expansion_to = newGame.expansion_to ? {id: newGame.expansion_to.id ,name: newGame.expansion_to.name} : null}" return-object/>
                      </v-col>
                      <v-col>
                        <v-combobox label="genre" v-model="newGame.genre" item-text="name" item-value="id" :items="genres" style="min-width: 100px;" :rules="[rules.noString]"
                                    clearable :error-messages="error['genre-s' + newGame.id]" @input="() =>{error['genre-s' + newGame.id] = undefined; if(newGame.genre === ''){newGame.genre = null}}" return-object/>
                        <v-expand-transition>
                          <v-card v-if="typeof newGame.genre === 'string'" elevation="2">
                            <v-btn color="success" @click="patchNewGenre(newGame, newGame.genre)" style="width: 100%; font-size: 0.6em; min-width: 0;" outlined text>Lägg till</v-btn>
                          </v-card>
                        </v-expand-transition>
                      </v-col>
                      <v-col>
                        <v-combobox label="platform" v-model="newGame.platform" item-text="name" item-value="id" :items="platforms" style="min-width: 100px;" persistent-hint hint="Krävs"
                                    :error-messages="error['platform-s'+ newGame.id]" @input="error['platform-s'+ newGame.id] = undefined" return-object :rules="[rules.noString, rules.notEmpty]"/>
                        <v-expand-transition>
                          <v-card v-if="typeof newGame.platform === 'string'" elevation="2">
                            <v-btn color="success" @click="patchNewPlat(newGame, newGame.platform)" style="width: 100%; font-size: 0.6em; min-width: 0;" outlined text>Lägg till</v-btn>
                          </v-card>
                        </v-expand-transition>
                      </v-col>
                      <v-col>
                        <v-text-field label="Bild Länk" v-model="newGame.image_link" type="link" style="min-width: 100px;"/>
                      </v-col>
                      <v-col cols="12">
                        <v-expansion-panels>
                          <v-expansion-panel>
                            <v-expansion-panel-header>{{newGame.owner && newGame.owner.name? 'Ägare: ' + newGame.owner.name : 'Ingen ägare'}}</v-expansion-panel-header>
                            <v-expansion-panel-content>
                              <v-row>
                                <v-col>
                                  <v-combobox label="Ägare" v-model="newGame.owner" item-text="name" item-value="id" :items="owners" clearable
                                              return-object style="min-width: 100px;" :rules="[rules.noString]" @input="() => {if(newGame.owner === ''){newGame.owner = null}}"/>
                                  <v-card v-if="typeof newGame.owner === 'string'" elevation="2">
                                    <v-btn color="success" @click="patchNewOwner(newGame, newGame.owner)" style="width: 100%; font-size: 0.6em; min-width: 0;" outlined text>Lägg till</v-btn>
                                  </v-card>
                                </v-col>
                                <v-col v-if="newGame.owner">
                                  <v-text-field label="Smeknamn" v-model="newGame.owner.nickname" style="min-width: 100px;"/>
                                </v-col>
                                <v-col v-if="newGame.owner">
                                  <v-text-field label="Telefon nr" v-model="newGame.owner.phone_number" style="min-width: 100px;"/>
                                </v-col>
                                <v-col v-if="newGame.owner">
                                  <v-text-field label="E-mejl" v-model="newGame.owner.email" style="min-width: 100px;"/>
                                </v-col>
                              </v-row>
                            </v-expansion-panel-content>
                          </v-expansion-panel>
                        </v-expansion-panels>
                      </v-col>
                      <v-col cols="12">
                        <v-btn :color="error['s' + newGame.id]? 'error' :'success'" type="submit" :loading="loading['s' + newGame.id]">Spara</v-btn>
                        <span v-if="messages[newGame.id]">{{messages[newGame.id]}}</span>
                      </v-col>
                    </v-row>
                  </v-form>
                </v-row>
              </v-card-text>
            </v-card>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </template>
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
      <td v-if="item.name !== 'DELETED'" :colspan="headers.length" class="v-data-table__expanded v-data-table__expanded__content px-0" style="margin: 10px;">
        <v-card tile flat :loading="loading['s' + item.id]">
          <v-alert v-if="error['s' + item.id]" color="error" text>{{error['s' + item.id]}}</v-alert>
          <v-card-text>
            <v-row>
              <v-col cols="11" style="padding: 0;">
                <v-btn outlined rounded color="blue" small @click="searchBoardgameAtlas(item)" :loading="loading['atlas-s' + item.id]">
                  <search-icon size="1x" style="margin-right: 5px;"/>
                  Sök i Boardgame Atlas
                </v-btn>
                <v-fade-transition>
                  <v-select v-if="searchResults[0]" v-model="searchSelect" :items="searchResults" item-text="name" return-object @input="fillEntry(item)"
                            label="Sökresultat" style="display: inline-block; margin: 10px;" dense/>
                </v-fade-transition>
              </v-col>
              <v-col sm="1" cols style="padding: 0;">
                <v-btn small outlined rounded @click="deleteGame(item)" :loading="loading['del' + item.id]" :color="error['del' + item.id] ? 'error' : ''" style="width: 100%;"><trash2-icon size="1.6x"/></v-btn>
              </v-col>
              <v-form @submit.prevent="updateGame(item)" v-model="valid[item.id]">
                <v-row>
              <v-col>
                <v-text-field label="namn" v-model="item.name" :messages="messages['name-s' + item.id]" :rules="[rules.notEmpty]"  style="min-width: 100px;"/>
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
                <v-textarea label="beskrivning" v-model="item.description" dense outlined/>
              </v-col>
                  <v-switch label="Aktiv" v-model="item.active" style="width: 100px; margin-left: 10px; margin-top: 30px;"/>
              <v-col>
                <v-autocomplete label="expansion till" v-model="item.expansion_to" :items="games" item-text="name" item-value="id" style="min-width: 100px;"
                                clearable :error-messages="error['expansion-s' + item.id]"
                                @input="() => { error['expansion-s' + item.id] = undefined;  item.expansion_to = item.expansion_to ? {id: item.expansion_to.id ,name: item.expansion_to.name} : null}" return-object/>
              </v-col>
              <v-col>
                <v-combobox label="genre" v-model="item.genre" item-text="name" item-value="id" :items="genres" style="min-width: 100px;" :rules="[rules.noString]"
                                clearable :error-messages="error['genre-s' + item.id]" @input="() =>{error['genre-s' + item.id] = undefined; if(item.genre === ''){item.genre = null}}" return-object/>
                <v-expand-transition>
                <v-card v-if="typeof item.genre === 'string'" elevation="2">
                  <v-btn color="success" @click="patchNewGenre(item, item.genre)" style="width: 100%; font-size: 0.6em; min-width: 0;" outlined text>Lägg till</v-btn>
                </v-card>
                </v-expand-transition>
              </v-col>
              <v-col>
                <v-combobox label="platform" v-model="item.platform" item-text="name" item-value="id" :items="platforms" style="min-width: 100px;"
                                :error-messages="error['platform-s'+ item.id]" @input="error['platform-s'+ item.id] = undefined" return-object :rules="[rules.noString]"/>
                <v-expand-transition>
                <v-card v-if="typeof item.platform === 'string'" elevation="2">
                    <v-btn color="success" @click="patchNewPlat(item, item.platform)" style="width: 100%; font-size: 0.6em; min-width: 0;" outlined text>Lägg till</v-btn>
                </v-card>
                </v-expand-transition>
              </v-col>
              <v-col>
                <v-text-field label="Bild Länk" v-model="item.image_link" type="link" style="min-width: 100px;"/>
              </v-col>
              <v-col cols="12">
                <v-expansion-panels>
                  <v-expansion-panel>
                    <v-expansion-panel-header>{{item.owner && item.owner.name? 'Ägare: ' + item.owner.name : 'Ingen ägare'}}</v-expansion-panel-header>
                    <v-expansion-panel-content>
                      <v-row>
                        <v-col>
                          <v-combobox label="Ägare" v-model="item.owner" item-text="name" item-value="id" :items="owners" clearable
                                          return-object style="min-width: 100px;" :rules="[rules.noString]" @input="() => {if(item.owner === ''){item.owner = null}}"/>
                          <v-card v-if="typeof item.owner === 'string'" elevation="2">
                              <v-btn color="success" @click="patchNewOwner(item, item.owner)" style="width: 100%; font-size: 0.6em; min-width: 0;" outlined text>Lägg till</v-btn>
                          </v-card>
                        </v-col>
                        <v-col v-if="item.owner">
                          <v-text-field label="Smeknamn" v-model="item.owner.nickname" style="min-width: 100px;"/>
                        </v-col>
                        <v-col v-if="item.owner">
                          <v-text-field label="Telefon nr" v-model="item.owner.phone_number" style="min-width: 100px;"/>
                        </v-col>
                        <v-col v-if="item.owner">
                          <v-text-field label="E-mejl" v-model="item.owner.email" style="min-width: 100px;"/>
                        </v-col>
                      </v-row>
                    </v-expansion-panel-content>
                  </v-expansion-panel>
                </v-expansion-panels>
              </v-col>
              <v-col cols="12">
                <v-btn :color="error['s' + item.id] ? 'error' :'success'" type="submit" :loading="loading['s' + item.id]" style="margin-right: 7px;">Spara</v-btn>
                <span v-if="messages[item.id]">{{messages[item.id]}}</span>
              </v-col>
                </v-row>
              </v-form>
            </v-row>
          </v-card-text>
        </v-card>
      </td>
    </template>
  </v-data-table>
</template>

<script lang="ts">
import { Component, Vue} from "vue-property-decorator"
import {SearchIcon, Trash2Icon} from "vue-feather-icons";
import {
  BoardgameAtlasGame,
  BoardgameAtlasMechanic,
  GameGenreData,
  LoehkGameData,
  OwnerData,
  PlatformData
} from "@/assets/ts/interfaces";
import {SessionStore} from "@/assets/ts/sessionStore";

@Component({
  components: { SearchIcon, Trash2Icon }
})
export default class Games extends Vue{
  constructor() {
    super()
    this.getData()
  }
  games: LoehkGameData[] = []
  genres: GameGenreData[] = []
  platforms: PlatformData[] = []
  owners: OwnerData[] = []
  newGame: LoehkGameData = {
    id: -1,
    created_at: null,
    description: null,
    expansion_to: null,
    genre: null,
    image_link: null,
    max_players: 0,
    max_playtime: 0,
    min_players: 0,
    min_playtime: 0,
    name: "",
    owner: null,
    platform: null as any,
    published_year: null,
    updated_at: null,
    active: true
  }
  headers = [
    {text: 'Namn', value: 'name', align: 'start', groupable: false },
    {text: 'Utgivnings år', value: 'published_year', align: 'center', groupable: true},
    {text: 'Senast updaterad', value: 'updated_at', align: 'center', groupable: false},
    {text: 'Skapad', value: 'created_at', align: 'right', groupable: false}
  ]
  rules = {
    noString: (value: OwnerData | PlatformData | GameGenreData | string): true | string =>{
      return typeof value !== "string"? true: 'Okända värden kan inte användas, tryck lägg till knappen eller välj ett annat värde'
    },
    notEmpty: (value: string | number): true | string => {
      return value || value === 0 ? true: "Fältet får inte vara tom"
    }
  }
  loading: boolean[] = []
  pageLoading = true
  error: string[] = []
  messages: string[] = []
  valid: boolean[] = []
  searchResults: BoardgameAtlasGame[] = []
  searchSelect: BoardgameAtlasGame | any = {}
  mechanicsList: BoardgameAtlasMechanic[] = []

  getData(): void{
    this.pageLoading = true

    fetch(process.env.VUE_APP_API_URL + '/loehk/games', {
      headers:{
        Authorization: SessionStore.getSessionId() ?? ""
      }
    })
      .then(res => res.json()).then(res => {
        this.games = res.games
        this.genres = res.genres
        this.platforms = res.platforms
        this.owners = res.owners

        //this.replaceNullObj()
    })
      .catch(() => this.$router.push('/login'))
    .finally(() => this.pageLoading = false)
  }

  updateGame(item: LoehkGameData): void{
    this.$set(this.messages, item.id, "")

    if(!this.valid[item.id]){
      return
    }

    this.$set(this.loading, 's' + item.id, true)
    this.$set(this.error, 's' + item.id, "")

    if(item.owner?.name === undefined){
      item.owner = null
      console.log("TypeError may have appeared, it can be ignored")
    }

    fetch(process.env.VUE_APP_API_URL + "/loehk/games", {
      method: "PUT",
      body: JSON.stringify(item),
      headers: {
        "content-type": "application/json; charset=UTF-8",
        Authorization: SessionStore.getSessionId() ?? ""
      }
    }).then(res => res.json()).then((res: LoehkGameData) => {
      item = res
      this.$set(this.messages, item.id, "Sparat!")
    }).catch(() => {
      this.$set(this.error, 's' + item.id, "Något gick fel när man försökte nå servern")
    }).finally( () => {
      this.$set(this.loading, 's' + item.id, false)
    })
  }

  insertGame(item: LoehkGameData): void{
    if(!this.valid[item.id]){
      return
    }

    this.$set(this.loading, 's' + item.id, true)
    this.$set(this.error, 's' + item.id, "")

    if(item.owner?.name === undefined){
      item.owner = null
      console.log("TypeError may have appeared, it can be ignored")
    }

    fetch(process.env.VUE_APP_API_URL + "/loehk/games", {
      method: "POST",
      body: JSON.stringify(item),
      headers: {
        "content-type": "application/json; charset=UTF-8",
        Authorization: SessionStore.getSessionId() ?? ""
      }
    }).then(res => res.json()).then((res: LoehkGameData) => {
      this.$set(this.games, this.games.length, res)
      this.newGame = {
        id: -1,
        created_at: null,
        description: null,
        expansion_to: null,
        genre: null,
        image_link: null,
        max_players: 0,
        max_playtime: 0,
        min_players: 0,
        min_playtime: 0,
        name: "",
        owner: null,
        platform: null as any,
        published_year: null,
        updated_at: null,
        active: true
      }
      console.log(res)
      console.log(this.games)
    }).catch(() => {
      this.$set(this.error, 's' + item.id, "Något gick fel när man försökte nå servern")
    }).finally( () => {
      this.$set(this.loading, 's' + item.id, false)
    })
  }
/*
  replaceNullObj(): void{
    for (let game of this.games) {
      /*
      if (game.expansion_to === null){
        game.expansion_to = {}
      }

      if(game.genre === null){
        game.genre = {}
      }*/
      /*
      if(game.owner === null){
        game.owner = {} as any
      }
    }
  }
  */

  patchNewPlat(item: LoehkGameData, value: string): void{

    fetch(process.env.VUE_APP_API_URL + "/loehk/games", {
      method: "PATCH",
      body: JSON.stringify({platform: value}),
      headers: {
        "content-type": "application/json; charset=UTF-8",
        Authorization: SessionStore.getSessionId() ?? ""
      }
    }).then(res => res.json()).then((res: PlatformData) => {
      this.platforms.push(res)
      item.platform = res
    })
  }

  patchNewGenre(item: LoehkGameData, value: string): void{
    fetch(process.env.VUE_APP_API_URL + "/loehk/games", {
      method: "PATCH",
      body: JSON.stringify({genre: value}),
      headers: {
        "content-type": "application/json; charset=UTF-8",
        Authorization: SessionStore.getSessionId() ?? ""
      }
    }).then(res => res.json()).then((res: GameGenreData) => {
      this.genres.push(res)
      item.genre = res
    })
  }

  patchNewOwner(item: LoehkGameData, value: string): void{
    fetch(process.env.VUE_APP_API_URL + "/loehk/games", {
      method: "PATCH",
      body: JSON.stringify({owner: value}),
      headers: {
        "content-type": "application/json; charset=UTF-8",
        Authorization: SessionStore.getSessionId() ?? ""
      }
    }).then(res => res.json()).then((res: OwnerData) => {
      this.owners.push(res)
      item.owner = res
    })
  }

  deleteGame(item: LoehkGameData): void{
    this.$set(this.loading, "del" + item.id, true)
    this.$set(this.error, "del" + item.id, "")
    this.$set(this.error, "s" + item.id, "")

    fetch(process.env.VUE_APP_API_URL + "/loehk/games/" + item.id, {
      method: "DELETE",
      headers:{
        Authorization: SessionStore.getSessionId() ?? ""
      }
    }).then(res => {
      if(res.ok){
        item.name = "DELETED"
      } else {
        this.$set(this.error, "del" + item.id, "Something went wrong in the server")
        this.$set(this.error, "s" + item.id, "Ett problem uppstod i servern")
      }
    }).catch(() => {
      this.$set(this.error, "del" + item.id, "Something went wrong in the server")
      this.$set(this.error, "s" + item.id, "Kunde inte nå servern")
    })
    .finally(()=> {
      this.$set(this.loading, "del" + item.id, false)
    })
  }

  searchBoardgameAtlas(item: LoehkGameData): void{
    console.log('click')
    this.error = []
    this.$set(this.loading,'atlas-s' + item.id, true)
    fetch('https://api.boardgameatlas.com/api/search?client_id=E23Rb2sc1L&limit=6&name=' + item.name)
      .then(res => res.json()).then((res: {games: BoardgameAtlasGame[], count: number}) => {
        console.log(res.games[0])
        if(res.games[0] === undefined){
          this.error['s' + item.id as any] = 'Kunde inte hitta spelet i Boardgame Atlas'
          return
        }
        this.searchResults = res.games
        this.searchSelect = this.searchResults[0]

        if(this.mechanicsList[0]){
          this.fillEntry(item)
        }
        else {
          fetch('https://api.boardgameatlas.com/api/game/mechanics?client_id=E23Rb2sc1L')
            .then(res => res.json()).then((res: {mechanics: BoardgameAtlasMechanic[]}) => {
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

  fillEntry(item: LoehkGameData): void{
    this.error = []
    item.description = this.searchSelect.description_preview
    item.published_year = this.searchSelect.year_published.toString()
    item.min_players = this.searchSelect.min_players
    item.max_players = this.searchSelect.max_players
    item.min_playtime = this.searchSelect.min_playtime
    item.max_playtime = this.searchSelect.max_playtime
    item.image_link = this.searchSelect.image_url

    this.error['platform-s' + item.id as any] = "Troligtvis brädspel"

    if(this.searchSelect.mechanics[0]) {
      this.error['genre-s' + item.id as any] = ''
      for (const source of this.searchSelect.mechanics) {
        for (const mechanic of this.mechanicsList) {
          if (mechanic.id === source.id) {
            this.error['genre-s' + item.id as any] += mechanic.name + ', '
            break
          }
        }
      }
    }
    if(this.searchSelect.type === "expansion"){
      this.error['expansion-s' + item.id as any] = 'Är en expansion!'
    }
    this.messages['name-s' + item.id as any] = this.searchSelect.name
  }

}
</script>
