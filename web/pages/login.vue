<template>
    <v-container>
        <v-card>
            <v-card-text>
                <v-row justify="center">
                    <v-col>Logga in</v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-form @submit.prevent="submit()">
                            <v-row>
                                <v-col>
                                    <v-text-field outlined autofocus type="email" name="email" id="email" label="E-Post"></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field outlined type="password" name="password" id="password" label="Lösenord"></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-btn color="primary" type="submit">Logga in</v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator'
import {SessionStore} from "@/store/sessionStore";

  @Component
  export default class loginPage extends Vue{

    submit (): void{
      const inputs = document.getElementsByTagName('input')
      fetch(process.env.NUXT_ENV_API_URL + "/login", {

        // Adding method type
        method: "POST",

        // Adding headers to the request
        headers: {
          "Content-type": "application/json; charset=UTF-8",
          "Authorization": btoa(inputs[0].value + '|' + inputs[1].value)
        }
      })
        // Converting to JSON
        .then((res) => res.json())
        // Handling the results
        .then( (res: {token: string}) => {
            SessionStore.setSessionId(res.token)
            this.$router.push('/loehk/home')
        })
    }
  }
</script>
