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

/**
 * A count page that saves the count to the API which is synced to all users on the page. The page is not accessible
 * from the navigation bar. The count can be increased, decreased reset by clicking the buttons.
 */
@Component({
  components:{
    XCircleIcon,
    PlusCircleIcon,
    MinusCircleIcon,
    RefreshCwIcon
  }
})
export default class Counter extends Vue{
  /**
   * The content of the counter, gets the value from the server and sets an interval to update it.
   */
  constructor() {
    super()
    this.doCount('get')
    setInterval(this.doCount, 2000, ['get'])
  }

  // The current value of the counter
  count: number | null = null
  // Displays the loading indicator when true
  loading = false
  // The error message to display if set
  error: string | null = null
  // The timestamp of the last update of the counter
  time: string | null = null

  /**
   * Performs a count action that is sent to the server.
   * @param {string} direction The action to perform, it can be 'increase', 'decrease', 'get' or 'reset'. Defaults to 'get'.
   * @public
   */
  doCount(direction?: string | 'increase' | 'decrease' | 'get' | 'reset'): void {
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
        return res.json() // If the response is ok, parse the json
      } else { // If the response is not ok, set the error message
        this.error = "Servern hade ett problem med att hämta värdet"
        return null
      }
    }).then(res => {
      // Apply the parsed json to the counter variables
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
