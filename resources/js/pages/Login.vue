<template>
    <b-row class="justify-content-md-center m-5">
        <b-col col md="6">
            <b-alert :show="hasError" variant="danger">Unauthorized.</b-alert>
            <b-card header="Login">
                <b-card-body>
                    <form autocomplete="off" @submit.prevent="login" method="post">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" v-model="password" required>
                        </div>
                        <b-form-checkbox
                            id="checkbox-1"
                            v-model="remember"
                            name="checkbox-1"
                            value="accepted"
                            unchecked-value="not_accepted"
                        >
                            Remember me
                        </b-form-checkbox>
                        <hr>
                        <b-button type="submit" variant="outline-primary">Submit</b-button>
                    </form>
                </b-card-body>
            </b-card>
        </b-col>
    </b-row>
</template>

<script>
    export default {
        data() {
            return {
                email: null,
                password: null,
                remember: false,
                hasError: false
            }
        },
        methods: {
            login() {
                let app = this
                this.$auth.login({
                    data: {
                        email: app.email,
                        password: app.password
                    },
                    error: function (error) {
                        this.hasError = true;
                    }
                })
            }
        }
    }
</script>
