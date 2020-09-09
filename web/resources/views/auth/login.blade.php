@extends('layouts.base')

@section('content')
    <v-container>
        <v-card>
            <v-card-text>
                <v-row justify="center">
                    <v-col>Logga in</v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-form method="POST" action="/login">
                            @csrf
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
                                    <v-btn type="submit">Logga in</v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-container>
@endsection
