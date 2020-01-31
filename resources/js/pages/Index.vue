<template>
    <div>
        <header>
            <b-navbar type="dark" variant="primary">
                <b-navbar-brand :to="{ name: 'home' }">Vost4Crowd</b-navbar-brand>
                <b-navbar-nav v-if="$auth.check()">
                    <b-nav-item-dropdown text="Projects" right>
                        <b-dropdown-item :to="{ name: 'projects' }">List</b-dropdown-item>
                        <b-dropdown-item :to="{ name: 'projects.create' }">Create</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                    <b-nav-item-dropdown v-if="$auth.check()" :text="$auth.user().name" right>
                        <b-dropdown-item href="#">Profile</b-dropdown-item>
                        <b-dropdown-item @click.prevent="$auth.logout()">Sign Out</b-dropdown-item>
                    </b-nav-item-dropdown>
                    <b-nav-item v-if="!$auth.check()" :to="{ name: 'login' }">Sign In</b-nav-item>
                </b-navbar-nav>
            </b-navbar>
        </header>
        <b-container :fluid="isFluid" class="p-0">
            <router-view></router-view>
        </b-container>
    </div>
</template>
<script>
    export default {
        data() {
          return {
              isFluid: false
          }
        },
        created() {
            this.checkIfContainerIsFluid()
        },
        updated() {
            this.checkIfContainerIsFluid()
        },
        methods: {
            checkIfContainerIsFluid() {
                const {isFluid} = this.$route.meta;
                this.isFluid = isFluid === true ? isFluid : false;
            }
        }
    }
</script>
