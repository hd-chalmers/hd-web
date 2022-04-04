<template>
  <v-card class="mb-3" :elevation="elevation">
    <v-card-title>
      <h5>
        {{title}}
        <v-btn v-if="facebook" style="background-color: transparent;" icon color="blue" target="_blank"
               @click="$ga.social('Facebook', 'Events Facebook click', facebook)" v-bind:href="facebook">
          <facebook-icon/>
        </v-btn>
      </h5>
    </v-card-title>
    <v-card-subtitle :style="compact ? 'padding-bottom: 0;': ''">
      <h3>
        {{date.toLocaleString('sv', {
        year: 'numeric',
        month: 'numeric',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        weekday: 'long'
      })}}
      </h3>
    </v-card-subtitle>
    <v-list v-if="compact && (location || description)">
      <v-list-item>
        <v-list-item-subtitle>
          <span v-if="location" style="margin-right: 10px;">
            <map-pin-icon size="1x"/>
            Plats: {{location}}
          </span>

          <span v-if="description">
            <align-left-icon size="1x" style="margin-right: 5px;"/>
            {{description}}
          </span>
        </v-list-item-subtitle>
      </v-list-item>
    </v-list>
    <v-card-text v-else-if="location || description">
      <div v-if="location" style="margin-right: 10px;">
        <map-pin-icon size="1x"/>
        Plats: {{location}}
      </div>

      <br>

      <div v-if="description">
        <align-left-icon size="1x" style="margin-right: 5px;"/>
        {{description}}
      </div>
    </v-card-text>
  </v-card>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator"
import {FacebookIcon, MapPinIcon, AlignLeftIcon} from 'vue-feather-icons'


@Component({
  components: {
    FacebookIcon,
    MapPinIcon,
    AlignLeftIcon
  }
})
export default class EventCard extends Vue{
  @Prop() title = {
    type: String,
    required: true
  }
  @Prop() date = {
    type: Date,
    required: true
  }
  @Prop() location = String
  @Prop() facebook = String
  @Prop() description = String
  @Prop() compact = Boolean
  @Prop() elevation = {
    type: String,
    default: "6"
  }
}
</script>

<style scoped>

</style>
