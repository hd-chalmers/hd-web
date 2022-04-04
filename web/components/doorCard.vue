<template>
  <v-card @click="showDate()" style="cursor: default;" elevation="6">
    <v-card-text class="flex justify-space-between align-content-center" style="display: flex; align-items: center; transition: color 1s ease; height: 100%;" id="doorCard">
      <template v-if="!doorLoading">
        <v-scroll-x-transition leave-absolute>
          <lock-icon v-if="doorIcon === 'lock'"/>
        </v-scroll-x-transition>
        <v-scroll-x-transition leave-absolute>
          <unlock-icon v-if="doorIcon === 'unlock'"/>
        </v-scroll-x-transition>
        <v-scroll-x-transition leave-absolute>
          <alert-circle-icon v-if="doorIcon === 'alert'"/>
        </v-scroll-x-transition>
        <v-scroll-x-transition leave-absolute>
          <span v-if="!doorShowDate">Hoppas du har en bra dag :)</span>
        </v-scroll-x-transition>
        <v-scroll-x-transition leave-absolute>
          <span v-if="doorShowDate" style="line-height: 12px; font-size: 11px; text-align: right;">{{doorOpenTimestamp}} <br> ca {{doorDuration}} sedan</span>
        </v-scroll-x-transition>
      </template>
      <template v-if="doorLoading">
        <v-progress-circular indeterminate color="primary"></v-progress-circular>
        <v-skeleton-loader style="width: 20vw;" type="text"></v-skeleton-loader>
      </template>
    </v-card-text>
  </v-card>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
import {AlertCircleIcon, LockIcon, UnlockIcon} from "vue-feather-icons";

@Component({
  components: {
    LockIcon,
    UnlockIcon,
    AlertCircleIcon,
  }
})
export default class DoorCard extends Vue{
  created():void {
    this.getStatus()

    this.interval = setInterval(this.getStatus, 10000);
    this.intervalCallback(this.interval as any)
  }

  @Prop() intervalCallback = Function

  doorShowDate = false
  doorLoading = true
  doorState: boolean | null = null
  doorDuration = ''
  doorOpenTimestamp = '0000-00-00 00:00:00'
  doorIcon = 'mdi-alert-circle'
  doorColor: string | undefined = 'black'
  interval: NodeJS.Timer | undefined

  getStatus(): void {
    fetch(process.env.NUXT_ENV_API_URL + '/door')
      .then(res => {
        if (res.ok) {
          return res.json()
        } else {
          this.doorState = null
          this.doorIcon = 'alert'
          this.doorColor = this.$vuetify.theme.currentTheme.warning?.toString()
          return null
        }
      }).then((res: { status: boolean | null, updated: string, duration_str: string, duration: number }) => {
      if (res) {
        this.doorState = res.status
        this.doorOpenTimestamp = res.updated
        this.doorDuration = res.duration_str
        if (res.status) {
          this.doorIcon = 'unlock'
          this.doorColor = this.$vuetify.theme.currentTheme.success?.toString()
        } else if (res.status === null) {
          this.doorState = null
          this.doorIcon = 'alert'
          this.doorColor = this.$vuetify.theme.currentTheme.warning?.toString()
        } else {
          this.doorIcon = 'lock'
          this.doorColor = this.$vuetify.theme.currentTheme.error?.toString()
        }
      }
    }).catch((err: Error) => {
      this.doorState = null
      this.doorIcon = 'alert'
      this.doorColor = this.$vuetify.theme.currentTheme.warning?.toString()

      this.$ga.exception('(Door) ' + err.message)
    }).finally(() => {
      this.doorLoading = false
      this.setColor()
    })
  }

  showDate(): void {
    this.getStatus()
    this.doorShowDate = true
    setTimeout(() => this.doorShowDate = false, 3000)

    this.$ga.event('Door', 'Reveal timestamp')
  }

  setColor(): void {
    const door = document.getElementById('doorCard') as HTMLElement
    door.style.color = this.doorColor as string

  }
}
</script>

<style scoped>

</style>
