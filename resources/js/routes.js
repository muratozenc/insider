import TeamIndex from './components/Teams/Index.vue';
import TeamCreate from './components/Teams/Create.vue';
import TeamEdit from './components/Teams/Edit.vue';
import SelectTeams from './components/Simulation/SelectTeams.vue';
import GeneratedFixtures from './components/Simulation/GeneratedFixtures.vue';
import Simulation from './components/Simulation/Simulation.vue';

export const routes = [
    {
        path: '/teams',
        component: TeamIndex,
        name: "TeamIndex"
    },
    {
        path: '/teams/create',
        component: TeamCreate,
        name: "TeamCreate"
    },
    {
        path: '/teams/edit/:teamId',
        component: TeamEdit,
        name: "TeamEdit"
    },
    {
        path: '/simulation/select-teams',
        component: SelectTeams,
        name: "SelectTeams"
    },
    {
        path: '/simulation/generated-fixtures',
        component: GeneratedFixtures,
        name: "GeneratedFixtures"
    },
    {
        path: '/simulation/simulation',
        component: Simulation,
        name: "Simulation"
    }
];