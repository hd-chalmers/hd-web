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

    <!-- Compact event description -->
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

    <!-- Full event description -->
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

/**
 * A card component for a single event. It has a title, a date, a location and a description. It can also be compact
 * which will truncate the description and location. It can also have a facebook link. It only requires a title and date.
 */
@Component({
  components: {
    FacebookIcon,
    MapPinIcon,
    AlignLeftIcon
  }
})
export default class EventCard extends Vue{
  /**
   * Title of the event, required
   */
  @Prop({
    type: String,
    required: true
  }) readonly title!: string
  /**
   * Date of the event, required. Must be a Date object.
   */
  @Prop({
    type: Date,
    required: true
  }) readonly date!: Date
  /**
   * Location of the event, optional
   */
  @Prop(String) location: string | undefined
  /**
   * Facebook link for the event, optional
   */
  @Prop(String) facebook: string | undefined
  /**
   * Description of the event, optional
   */
  @Prop(String) description: string | undefined
  /**
   * Compact mode, optional. Default false. Will adjust padding and margins along with limiting the width of location and description.
   */
  @Prop({type: Boolean, default: false}) readonly compact!: boolean
  /**
   * Material elevation of the card, optional or must be a number. Default 6. Elevation is used for creating drop shadows, see vuetify docs for more info.
   */
  @Prop({
    type: String,
    default: "6"
  }) readonly elevation!: string
}
</script>

<style scoped>

</style>
