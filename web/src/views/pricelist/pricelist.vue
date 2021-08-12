<template>
  <v-container>
    <v-card light :loading="loading" id="pricelist">
      <v-alert v-if="error" color="error" text>{{error}}</v-alert>
      <v-card-title> <h2>Prislista</h2> </v-card-title>
      <v-card-subtitle style="padding-bottom: 0;">Här är saker man kan köpa i våra arr!</v-card-subtitle>
      <img src="/img/HD_logo.png" width="90px" id="printLogo"/>
      <v-card-text>
        <v-row>
        <v-col v-for="category in categories" v-bind:key="'c' + category.id">
          <div style="min-width: 300px;">
          <h2 :style="`color: ${$vuetify.theme.currentTheme.primary}; font-size: 1.6em; margin-bottom: 5px;`">{{category.name}}</h2>
          <div v-for="product in category.products" v-bind:key="'p' + product.id" class="productEntry"
               style="display: flex; justify-content: space-between; font-size: 1.3em; padding: 2.5px 0;">
            <strong>{{product.name}}</strong>
            <span>{{product.price}} kr</span>
          </div>
          </div>
        </v-col>
          <template v-if="loading">
            <v-col>
              <v-skeleton-loader type="article"></v-skeleton-loader>
            </v-col>
            <v-col>
              <v-skeleton-loader type="article"></v-skeleton-loader>
            </v-col>
          </template>
        </v-row>
      </v-card-text>
    </v-card>
    <footer-card class="hide" style="margin-top: 12px"/>
  </v-container>
</template>

<style>
  .productEntry:hover {
    background-color: #8884;
  }
  .productEntry {
    transition: background-color 0.5s;
  }

  #printLogo{
    position: absolute;
    right: 0;
    top: 0;
    display: none;
  }

  @media print {
    header, footer, .hide{
      display: none !important;
    }
    .container {
      max-width: 100% !important;
      padding: 0 !important;
    }
    main{
      padding: 0 !important;
    }

    .productEntry:hover {
      background-color: inherit;
    }

    #pricelist {
      box-shadow: none;
      border-radius: 0;
    }

    #printLogo{
      display: inline-block !important;
    }
  }
</style>

<script lang="ts">
import {Vue, Component} from "vue-property-decorator"
import footerCard from "@/components/footerCard.vue";

@Component({
  components: {
    footerCard
  }
})
export default class pricelist extends Vue{
  constructor() {
    super()
    this.getData()
  }

  loading = true
  error = ''
  categories = []

  getData(): void{
    this.loading = true
    fetch(process.env.VUE_APP_API_URL + '/pricelist').then(res => res.json()).then(res => {
      this.error = ''
      this.categories = res.categories
    })
      .catch(() => {
        this.error = 'Sidan kunde inte nå servern'
        setTimeout(() => this.getData(), 5000)
      })
      .finally(() => this.loading = false)
  }
}
</script>
