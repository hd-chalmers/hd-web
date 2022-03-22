<template>
  <v-container fluid>
    <v-card v-if="error">
      <v-alert text color="error">
        {{error}}
      </v-alert>
    </v-card>
    <v-card>
      <v-card-title>Räknare</v-card-title>
      <v-card-actions>
        <v-btn icon x-large @click="doCount('reset')">
          <x-circle-icon/>
        </v-btn>
        <v-btn icon x-large @click="doCount" :loading="loading">
          <refresh-cw-icon/>
        </v-btn>
      </v-card-actions>
      <v-card-text>
        <v-text-field type="number" v-model="count" readonly solo persistent-hint :hint="time">
          <template v-slot:prepend-inner>
            <v-btn icon x-large @click="doCount('increase')" tile>
              <plus-circle-icon/>
            </v-btn>
          </template>
          <template v-slot:append>
            <v-btn icon x-large @click="doCount('decrease')" tile>
              <minus-circle-icon/>
            </v-btn>
          </template>
        </v-text-field>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator";
import {XCircleIcon, PlusCircleIcon, MinusCircleIcon, RefreshCwIcon} from "vue-feather-icons";

@Component({
  components:{
    XCircleIcon,
    PlusCircleIcon,
    MinusCircleIcon,
    RefreshCwIcon
  }
})
export default class Counter extends Vue{
  constructor() {
    super()
    this.doCount('get')
    setInterval(this.doCount, 2000, ['get'])
  }
  count: number | null = null
  loading = false
  error: string | null = null
  time: string | null = null

  doCount(direction?: string): void {
    this.loading = true;
    fetch(
      process.env.NUXT_ENV_API_URL + "/count/"+ direction ?? "",
      {
        method:
          'post',
        headers:
          {
            'Content-Type':
              'application/json',
            'Accept':
              'application/json',
          },
      }).then(res => {
      if(res.ok) {
        return res.json()
      } else {
        this.error = "Servern hade ett problem med att hämta värdet"
        return null
      }
    }).then(res => {
      if(res) {
        this.error = null
        this.count = res.count
        this.time = res.changed ? "Senast ändrad: " + new Date(res.changed).toLocaleString('sv'): null
      }
    }).catch(() => {
      this.error = "Kunde inte nå servern"
    })
      .finally(() => {
        this.loading = false;
      })
  }
}
</script>

<style scoped>

</style>
