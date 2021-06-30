<template>
    <v-container>
        <v-card>
            <v-card-text>
                <v-row justify="center">
                    <v-col>Logga in</v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <!--v-form target="_self"-->
                            <v-row>
                                <v-col>
                                    <v-text-field type="email" name="email" id="email" label="E-Post"></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field type="password" name="password" id="password" label="Lösenord"></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-btn v-on:click="submit()" type="button">Logga in</v-btn>
                                </v-col>
                            </v-row>
                        <!--/v-form-->
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator'

  @Component
  export default class loginPage extends Vue{
    submit():void{
      const inputs = document.getElementsByTagName('input')
      fetch("http://localhost:8000/login", {

        // Adding method type
        method: "POST",

        // Adding body or contents to send
        body: JSON.stringify({
          email: inputs[0].value,
          password: inputs[1].value
        }),

        // Adding headers to the request
        headers: {
          "Content-type": "application/json; charset=UTF-8"
        }
      })
        // Converting to JSON
        .then(response => response.json())
        // Handling the results
        .then((res) => {
          if(res.status === 'success'){
            location.href = 'loehk'
          }
        })


    }
  }
</script>
