<template>
  <v-card elevation="4">
    <v-card-title>
      Kontakta Oss
    </v-card-title>
    <v-card-text id="footer">
      <v-row no-gutters>
        <v-col  class="flex flex-column align-right" style="display: flex; min-width: 167px;" cols="12" sm>
      <a href="mailto:hd@htek.chalmers.se" target="_blank" @click="$ga.social('E-mail', 'Click', 'HD@htek.chalmers.se')">
        <mail-icon size="1.5x"/>
        HD@htek.chalmers.se
        <external-link-icon size="0.8x"/>
      </a>
      <span>
      <home-icon size="1.5x"/>
      Nya Föreningstorget, Svea Källare, Lindholmen
      </span>
      <a href="https://www.facebook.com/HDChalmers/" target="_blank" @click="$ga.social('Facebook', 'Click', 'https://www.facebook.com/HDChalmers/')">
        <facebook-icon size="1.5x"/>
        @HDChalmers - HD / H-sektionens Datorförening
        <external-link-icon size="0.8x"/>
      </a>
        </v-col>
        <v-col  class="flex flex-column align-right" style="display: flex; min-width: 167px;" cols="12" sm>
      <a href="https://www.instagram.com/hdchalmers/" target="_blank" @click="$ga.social('Instagram', 'Click', 'https://www.instagram.com/hdchalmers/')">
        <instagram-icon size="1.5x"/>
        @hdchalmers
        <external-link-icon size="0.8x"/>
      </a>
      <a href="https://discord.gg/H8BZPtXbzx" target="_blank" @click="$ga.social('Discord', 'Join server', 'https://discord.gg/H8BZPtXbzx')">
        <message-square-icon size="1.5x"/>
        Discord server - HDs spelhörna
        <external-link-icon size="0.8x"/>
      </a>
      <span>
      <smile-icon size="1.5x"/>
      Om du ser nån av oss, Skrik/Vifta/fånga oss och prata på
      </span>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>

<script lang="ts">
  import { Vue, Component } from 'vue-property-decorator'
  import {MailIcon, HomeIcon, SmileIcon, FacebookIcon, InstagramIcon, MessageSquareIcon, ExternalLinkIcon} from 'vue-feather-icons'

  /**
   * A card with contact information and social media links. It is used as a footer and is appended to the end of the page.
   */
  @Component({
    components: {
      MailIcon,
      HomeIcon,
      SmileIcon,
      FacebookIcon,
      InstagramIcon,
      MessageSquareIcon,
      ExternalLinkIcon
    }
  })
  export default class footerCard extends Vue{
  }
</script>

<style>
  #footer span, #footer a {
    display: flex;
    justify-items: center;
    text-decoration: none;
    color: inherit;
    margin: 5px 0;
  }

  #footer span svg, #footer a svg{
    margin-right: 5px;
  }
</style>
