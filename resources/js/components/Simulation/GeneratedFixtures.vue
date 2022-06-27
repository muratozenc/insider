<template>
    <div class="container">
        <h2 class="text-center">Generated Fixture</h2>

        <div class="row">
            <div v-for="i in weekCount" class="col-md-4 mb-5">
                <div class="text-white bg-dark p-2">Week {{i}}</div>
                <div v-for="(fixture, key) of fixtures">
                    <div v-if="fixture.week_number == i" class="text-center">
                        <span class="text-center pull-left ">{{ fixture.home_team_name }}</span>
                        <span class="text-center w-100"> - </span>
                        <span class="text-center pull-right">{{ fixture.away_team_name }}</span>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary w-25" @click="startSimulation()">Start Simulation</button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                fixtures: {},
                weekCount: ''
            }
        },
        created() {
            this.getFixture();
        },
        methods: {
            getFixture() {
              this.axios.get('http://127.0.0.1:8000/api/fixtures').then(response => {
                this.fixtures = response.data.fixtures;
                this.weekCount = response.data.week_count;
                }).catch(error=>{
                    console.log(error)
                })
            },
            startSimulation() {
                this.$router.push({ name: 'Simulation' })
            },
        }
    }
</script>