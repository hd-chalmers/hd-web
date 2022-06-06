<template>
  <v-card @click="showDate()" style="cursor: default;" elevation="6">
    <v-card-text class="flex justify-space-between align-content-center" style="display: flex; align-items: center; transition: color 1s ease; height: 100%;" :style="'color:' + doorColor + ';'" id="doorCard">
      <template v-if="!doorLoading">
        <!-- Door icon -->
        <v-scroll-x-transition leave-absolute>
          <lock-icon v-if="doorIcon === 'lock'"/>
        </v-scroll-x-transition>
        <v-scroll-x-transition leave-absolute>
          <unlock-icon v-if="doorIcon === 'unlock'"/>
        </v-scroll-x-transition>
        <v-scroll-x-transition leave-absolute>
          <alert-circle-icon v-if="doorIcon === 'alert'"/>
        </v-scroll-x-transition>

        <!-- Door text -->
        <v-scroll-x-transition leave-absolute>
          <span v-if="!doorShowDate">Hoppas du har en bra dag :)</span>
        </v-scroll-x-transition>
        <v-scroll-x-transition leave-absolute>
          <span v-if="doorShowDate" style="line-height: 12px; font-size: 11px; text-align: right;">{{doorOpenTimestamp}} <br> ca {{doorDuration}} sedan</span>
        </v-scroll-x-transition>
      </template>

      <!-- Door loading animation -->
      <template v-if="doorLoading">
        <v-progress-circular indeterminate color="primary"></v-progress-circular>
        <v-skeleton-loader style="width: 20vw;" type="text"></v-skeleton-loader>
      </template>
    </v-card-text>
  </v-card>
</template>

<script lang="ts">
import {Component, VModel, Vue} from "vue-property-decorator";
import {AlertCircleIcon, LockIcon, UnlockIcon} from "vue-feather-icons";

/**
 * A card that displays the door status. It also displays the date when the door was last opened on click.
 * It also fetches the door status every 10 seconds from the server.
 * V-model is used to save the interval id, so it can be stopped when the component is destroyed.
 */
@Component({
  components: {
    LockIcon,
    UnlockIcon,
    AlertCircleIcon,
  }
})
export default class DoorCard extends Vue{
  /**
   * The constructor of the component which sets the interval for getting the door status.
   */
  created():void {
    this.getStatus()

    this.interval = setInterval(this.getStatus, 10000);
  }

  /**
   * Save the interval id to pass to the destroy method
   */
  @VModel({type: Number, required: true}) interval!: NodeJS.Timer

  // A boolean that is true when the date is shown, it is set by clicking the card and resets after a few seconds.
  doorShowDate = false
  // A boolean that is true when the door is loading, it is set by the getStatus method.
  doorLoading = true
  // The door status, it is set by the getStatus method. It's null when the door fails to load.
  doorState: boolean | null = null
  // The string duration since the door was last opened/closed, it is set by the getStatus method.
  doorDuration = ''
  // The timestamp when the door was last opened/closed, it is set by the getStatus method.
  doorOpenTimestamp = '0000-00-00 00:00:00'
  // The icon that is shown on the card, it is set by the getStatus method.
  doorIcon = 'alert'
  // The color of the text and icon, it is set by the getStatus method.
  doorColor: string | undefined = 'black'

  /**
   * Fetches the door status from the server and sets the data of the card.
   * It also sets the color of the card and icon.
   * @public
   */
  getStatus(): void {
    fetch(process.env.NUXT_ENV_API_URL + '/door')
      .then(res => {
        if (res.ok) {
          return res.json() // Parse as JSON if response is ok
        } else { // If response is not ok, set the state to null and show the alert icon
          this.doorState = null
          this.doorIcon = 'alert'
          this.doorColor = this.$vuetify.theme.currentTheme.warning?.toString()
          return null
        }
      }).then((res: { status: boolean | null, updated: string, duration_str: string, duration: number }) => {
        // Set the state and duration from the parsed json response
      if (res) {
        this.doorState = res.status
        this.doorOpenTimestamp = res.updated
        this.doorDuration = res.duration_str
        if (res.status) { // door is open
          this.doorIcon = 'unlock'
          this.doorColor = this.$vuetify.theme.currentTheme.success?.toString()
        } else if (res.status === null) { // door failed to load
          this.doorState = null
          this.doorIcon = 'alert'
          this.doorColor = this.$vuetify.theme.currentTheme.warning?.toString()
        } else { // door is closed
          this.doorIcon = 'lock'
          this.doorColor = this.$vuetify.theme.currentTheme.error?.toString()
        }
      }
    }).catch((err: Error) => { // If the request fails, set the state to null and show the alert icon
      this.doorState = null
      this.doorIcon = 'alert'
      this.doorColor = this.$vuetify.theme.currentTheme.warning?.toString()

      this.$ga.exception('(Door) ' + err.message)
    }).finally(() => { // Set the loading to false and set the color
      this.doorLoading = false
    })
  }

  /**
   * An event listener that is called when the card is clicked. It causes the card to show the date which is reset after a few seconds.
   * @public
   */
  showDate(): void {
    this.getStatus()
    this.doorShowDate = true
    setTimeout(() => this.doorShowDate = false, 3000)

    this.$ga.event('Door', 'Reveal timestamp')
  }
}
</script>

<style scoped>

</style>
