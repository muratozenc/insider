<template>
    <div class="container">
        <h2 class="text-center">Simulation</h2>

        <div class="row">

            <div class="table col-md-6 mb-5">

                <table class="w-100">
                    <thead class="text-white bg-dark">
                        <th class="p-2">Team Name</th>
                        <th class="text-center">Pts</th>
                        <th class="text-center">P</th>
                        <th class="text-center">W</th>
                        <th class="text-center">D</th>
                        <th class="text-center">L</th>
                        <th class="text-center">GD</th>
                    </thead>
                    <tbody>
                        <tr v-for="(standing, key) in standings">
                            <td>{{standing.name}}</td>
                            <td class="text-center">{{standing.point}}</td>
                            <td class="text-center">{{standing.played}}</td>
                            <td class="text-center">{{standing.win}}</td>
                            <td class="text-center">{{standing.draw}}</td>
                            <td class="text-center">{{standing.lost}}</td>
                            <td class="text-center">{{standing.goal_difference}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <div class="col-md-4 text-center mb-5">
                <span>Play All Weeks ({{leftWeek}} left, except current)</span>
                <button type="button" class="btn btn-primary w-100" @click="playAllWeeks()">Play All Weeks</button>
            </div>
            <div class="col-md-4 text-center mb-5">
                <span>Play Week : {{currentWeek}}</span>
                <button type="button" class="btn btn-primary w-100" @click="playNextWeek()">Play Next Week</button>
            </div>
            <div class="col-md-4 text-center mb-5">
                <span>Reset Match Data</span>
                <button type="button" class="btn btn-danger w-100 pull-right" @click="resetData()">Reset Data</button>
            </div>

            <div class="table col-md-6 mb-5">
                <table class="w-100">
                    <thead class="text-white bg-dark" >
                        <th class="p-2">Prediction</th>
                        <th>%</th>
                    </thead>
                    <tbody>
                        <tr v-for="(prediction, key) in predictions">
                            <td>{{prediction.name}}</td>
                            <td>{{prediction.predict}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="table col-md-6 mb-5">
                <table class="w-100">
                    <thead class="text-white bg-dark">
                        <th class="p-2">Home Team Name</th>
                        <th class="text-center">Home Team Score</th>
                        <th class="text-center">Away Team Score</th>
                        <th>Away Team Name</th>
                        <th>Winner</th>
                        <th class="text-center">Week No</th>
                        <th class="text-center">Played</th>
                        <th class="text-center">Action</th>
                    </thead>
                    <tbody>
                        <tr v-for="(fixture, key) in fixtures" v-if="fixture.played=='Yes'">
                            <td>{{fixture.home_team_name}}</td>
                            <td class="text-center"><input type="number" v-model="fixture.home_team_score" style="width:40px;"></input></td>
                            <td class="text-center"><input type="number" v-model="fixture.away_team_score" style="width:40px;"></input></td>
                            <td>{{fixture.away_team_name}}</td>
                            <td>{{fixture.winner_team_name}}</td>
                            <td class="text-center">{{fixture.week_number}}</td>
                            <td class="text-center">{{fixture.played}}</td>
                            <td class="text-center"><button type="button" class="btn btn-primary" @click="updateFixtureRecord(fixture.id, fixture)">Save</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div v-if="this.fixtures.length == 0" class="text-center">Please click to "Reset Data" button to select teams for starting the simulation!</div>
            
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                fixtures: {},
                standings: {},
                predictions: {},
                weekCount: '',
                currentWeek: '',
                leftWeek: '',
                overAllCoefficient: ''
            }
        },
        created() {
            this.getFixtures();
            this.getStandings();
            this.getPredictions();
        },
        methods: {
            getFixtures() {
              this.axios.get('http://127.0.0.1:8000/api/fixtures').then(response => {
                this.fixtures = response.data.fixtures;
                this.weekCount = response.data.week_count;
                this.currentWeek = response.data.current_week;
                this.leftWeek = response.data.left_week;
                if (this.fixtures.length == 0){
                    this.$router.push({ name: 'SelectTeams' });
                };
                }).catch(error=>{
                    console.log(error)
                })
            },
            getStandings() {
              this.axios.get('http://127.0.0.1:8000/api/standings').then(response => {
                this.standings = response.data.standing;
                }).catch(error=>{
                    console.log(error)
                })
            },
            playNextWeek() {
                this.axios.get('http://127.0.0.1:8000/api/play-next-week').then(response => {
                    
                    this.getStandings();
                    this.getPredictions();
                    this.getFixtures();
                }).catch(error=>{
                    console.log(error)
                })
            },
            playAllWeeks() {
                this.axios.get('http://127.0.0.1:8000/api/play-all-weeks').then(response => {
                    this.getFixtures();
                    this.getStandings();
                    this.getPredictions();
                }).catch(error=>{
                    console.log(error)
                })
            },
            resetData() {
                this.axios.get('http://127.0.0.1:8000/api/reset-data').then(response => {
                    this.$router.push({ name: 'SelectTeams' })
                }).catch(error=>{
                    console.log(error)
                })
            },
            updateFixtureRecord(elementId, fixtureRecord) {
                this.axios.patch(`http://127.0.0.1:8000/api/fixtures/`+fixtureRecord.id, fixtureRecord).then((response) => {
                        this.getFixtures();
                        this.getStandings();
                        this.getPredictions();
                    });
            },
            getPredictions() {
                this.axios.get('http://127.0.0.1:8000/api/predictions').then(response => {
                    this.predictions = response.data.predictions;
                }).catch(error=>{
                    console.log(error)
                })
            }
        
        }
    }
</script>