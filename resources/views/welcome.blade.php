<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Händelser</title>

        {{-- Styles --}}
        <link rel="stylesheet" type="text/css" href="/css/app.css">
    </head>
    <body class="bg-grey-lighter">
        <div id="app">
            <div class="container mx-auto p-8 max-w-3xl">

                <div class="mb-6" v-cloak>
                    <a href="javascript:void(0)" class="btn-block btn" @click="showFilter = !showFilter" v-if="!showFilter">Visa filtrering</a>
                    <a href="javascript:void(0)" class="btn-block btn active" @click="showFilter = !showFilter" v-if="showFilter">Stäng filtrering</a>
                </div>

                <div class="mb-5 p-6 shadow bg-white border border-blue-lighter" v-if="showFilter" v-cloak>
                    <div class="md:flex">
                        <div class="md:w-1/2 md:mr-2 mb-4">
                            <multiselect v-model="selected_types" :options="types" placeholder="Välj en eller flera typer" :multiple="true" :taggable="true" :hide-selected="true" :create-tag="undefined"></multiselect>
                        </div>

                        <div class="md:w-1/2 md:ml-2 mb-4">
                            <multiselect v-model="location_name" :options="locations" placeholder="Välj ett eller flera områden" :multiple="true" :taggable="true" :hide-selected="true" :create-tag="undefined"></multiselect>
                        </div>
                    </div>

                    <input type="submit" value="Filtrera" class="btn btn-sm" @click="filter">
                </div>

                <h6 class="text-xl mb-5">Resultat</h6>

                <div class="p-8" v-if="events.length === 0 && !loadingEvents" v-cloak>
                    Verkar inte ha hittat något..
                </div>

                <div class="p-8" v-if="loadingEvents">
                    <div class="loader">Loading...</div>
                </div>

                <div class="bg-white p-8 rounded border shadow mb-8 animate bounceIn" v-for="event in events" v-cloak>
                    <div>@{{ event.name }}</div>

                    <div class="pt-4 text-sm mb-3">
                        @{{ event.summary }}
                    </div>

                    <a :href="event.url" class="no-underline text-xs" target="_blank" style="color: #6cb2eb;">Visa på polisen.se</a>
                </div>

                {{-- <button class="btn">Click me</button>
                <a href="#" class="btn">Click me</a>
                <input type="submit" class="btn" value="Click me"> --}}
            </div>
        </div>

        {{-- Scripts --}}
        <script src="/js/app.js"></script>
    </body>
</html>
