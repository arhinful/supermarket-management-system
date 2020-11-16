<template>
    <div>
        <v-snackbar
            v-model="snack"
            :timeout="3000"
            :color="snackColor"
        >
            {{ snackText }}

            <template v-slot:action="{ attrs }">
                <v-btn
                    v-bind="attrs"
                    text
                    @click="snack = false"
                >
                    Close
                </v-btn>
            </template>
        </v-snackbar>
        <v-container>
            <v-row class="no-gutters">

                <v-col class="col-12">
                    <v-row>
                        <v-col class="col-6">Name</v-col>
                        <v-col class="col-6">{{user.name}}</v-col>
                    </v-row>
                </v-col>

                <v-col class="col-12">
                    <v-row>
                        <v-col class="col-6">Email / Username</v-col>
                        <v-col class="col-6">{{user.email}}</v-col>
                    </v-row>
                </v-col>

                <v-col class="col-12">
                    <v-row>
                        <v-col class="col-6">Made an update on</v-col>
                        <v-col class="col-6">{{user.updated_at}}</v-col>
                    </v-row>
                </v-col>

                <v-col class="col-12">
                    <v-row>
                        <v-col class="col-6">Created On</v-col>
                        <v-col class="col-6">{{user.created_at}}</v-col>
                    </v-row>
                </v-col>

                <v-col class="col-12"><hr></v-col>

                <v-col class="col-12">
                    <v-row>
                        <v-col class="col-6">
                            <v-btn dark @click="show_update_profile = true">update Profile</v-btn>
                        </v-col>
                        <v-col class="col-6">
                            <v-btn class="text-white" color="red" @click="show_update_password = true">update Password</v-btn>
                        </v-col>
                    </v-row>
                </v-col>

            </v-row>


            <!-- update profile modal -->
            <v-dialog v-model="show_update_profile" class="ml-5" max-width="500px">
                <v-card>
                    <v-card-text>
                        <v-container>
                            <v-form>
                                <v-card-title class="blue text-white">Update Profile</v-card-title>
                                <v-row no-gutters class="black--text">

                                    <v-col class="col-12">
                                        <v-text-field label="Name" v-model="user.name"></v-text-field>
                                    </v-col>

                                    <v-col class="col-12">
                                        <v-text-field label="Username" v-model="user.email"></v-text-field>
                                    </v-col>

                                </v-row>
                            </v-form>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click.stop="show_update_profile = !show_update_profile">Cancel</v-btn>
                        <v-btn color="blue darken-1" text @click="saveProfile">Save</v-btn>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
            </v-dialog>


            <!-- update password modal -->
            <v-dialog v-model="show_update_password" class="ml-5" max-width="500px">
                <v-card>
                    <v-card-text>
                        <v-container>
                            <v-form>
                                <v-card-title class="blue text-white">Update Password</v-card-title>
                                <v-row no-gutters class="black--text">

                                    <v-col class="col-12">
                                        <v-text-field label="Password" v-model="password"></v-text-field>
                                    </v-col>

                                    <v-col class="col-12">
                                        <v-text-field label="New Password" v-model="new_password"></v-text-field>
                                    </v-col>

                                    <v-col class="col-12">
                                        <v-text-field label="Confirm New Password" v-model="password_confirmation"></v-text-field>
                                    </v-col>

                                </v-row>
                            </v-form>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click.stop="show_update_password = !show_update_password">Cancel</v-btn>
                        <v-btn color="blue darken-1" text @click="savePassword">Save</v-btn>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
            </v-dialog>

        </v-container>
    </div>
</template>

<script>
    export default {
        name: "Profile",
        data: ()=>({
            user: {},
            show_update_profile: false,
            show_update_password: false,
            name_: '',
            username: '',
            password: '',
            new_password: '',
            password_confirmation: '',
            show_this: true,
            snack: false,
            snackColor: '',
            snackText: '',
        }),
        methods: {
            fetchUser(){
                axios.get('worker/view').then((res)=>{
                    this.user = res.data['user']
                })
            },
            saveProfile(){
                this.name_ = this.user.name
                this.username = this.user.email
                if (this.name_ === '' || this.username === ''){
                    this.snack = true
                    this.snackColor = 'error'
                    this.snackText = 'all fields are required'
                    return
                }
                axios.post('worker/update-my-profile', {
                    name: this.name_,
                    username: this.username
                }).then((res)=>{
                    this.snack = true
                    this.snackColor = 'success'
                    this.snackText = res.data['mess']
                    this.show_update_profile = false
                    this.fetchUser()
                })
            },
            savePassword(){
                if (this.password === '' || this.new_password === ''
                    || this.password_confirmation === '' || this.password_confirmation !== this.new_password){
                    this.snack = true
                    this.snackColor = 'error'
                    this.snackText = 'Enter correct data and try again'
                    return
                }
                axios.post('worker/check-user-password', {password: this.password}).then((res)=>{
                    if (res.data['result'] === 'match'){
                        axios.post('worker/update-my-password', {
                            password: this.new_password,
                            password_confirmation: this.password_confirmation,
                        }).then((res)=>{
                            this.snack = true
                            this.snackColor = 'success'
                            this.snackText = res.data['mess']
                            this.show_update_password = false
                            this.password = ''
                            this.confirm_password = '';
                            this.new_password = '';
                        })
                    }
                    else if (res.data['result'] === 'not-match'){
                        this.snack = true
                        this.snackColor = 'error'
                        this.snackText = 'Incorrect password, please try again'
                    }
                })

            }
        },
        created() {
            this.fetchUser()
        }
    }
</script>

<style scoped>

</style>
