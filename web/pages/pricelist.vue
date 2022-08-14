<template>
  <v-container>
    <v-card light :loading="loading" id="pricelist">
      <v-alert v-if="error" color="error" text>{{error}}</v-alert>
      <v-card-title> <h2>Prislista</h2> </v-card-title>
      <v-card-subtitle style="padding-bottom: 0;">Här är saker man kan köpa i våra arr!</v-card-subtitle>
      <!-- Logo that is only shown when printing -->
      <img src="/img/HD_logo.webp" width="90" id="printLogo" alt="HD:s logotyp"/>
      <v-card-text>
        <v-row>

          <template v-for="category in categories">
            <v-col v-bind:key="'c' + category.id" v-if="category.products.length">
              <div style="min-width: 200px;">
                <h2 :style="`color: ${$vuetify.theme.currentTheme.primary}; font-size: 1.6em; margin-bottom: 5px;`">{{category.name}}</h2>

                <div v-for="product in category.products" v-bind:key="'p' + product.id" class="productEntry"
                     style="display: flex; justify-content: space-between; font-size: 1.3em; padding: 2.5px 0;">
                  <strong>{{product.name}}</strong>
                  <span>{{product.price}} kr</span>
                </div>

              </div>
            </v-col>
          </template>

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

  /* Print styles to hide page components and adjust logo */
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
import footerCard from "@/components/common/footerCard.vue";
import {PricelistCategory} from "@/assets/interfaces";

/**
 * A page that shows the pricelist however it is not accessible from the navbar. When printing, the logo is shown and
 * other elements are hidden. On hover, the background color is changed on that entry.
 */
@Component({
  components: {
    footerCard
  }
})
export default class pricelist extends Vue{
  mounted() {
    this.getData()
  }

  // Displays loading animation when true
  loading = true
  // Displays error message when set
  error = ''
  // The categories of the pricelist which contains the products within them
  categories: PricelistCategory[] = []

  /**
   * Gets the data from the server and sets the categories to be displayed.
   * @public
   */
  getData(): void{
    this.loading = true
    fetch(process.env.NUXT_ENV_API_URL + '/pricelist').then(res => res.json()).then((res: PricelistCategory[]) => {
      this.error = ''
      this.categories = res
    })
      .catch(() => {
        this.error = 'Sidan kunde inte nå servern'
        setTimeout(() => this.getData(), 5000)
      })
      .finally(() => this.loading = false)
  }
}
</script>
