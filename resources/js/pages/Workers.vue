<template>
    <div>

        <add-worker v-if="addUser" v-on:close_add_user=" closeAddUser"></add-worker>

        <v-tooltip top>
            <template v-slot:activator="{ on, attrs }">
                <v-fab-transition>
                    <v-btn
                        color="pink"
                        fab
                        dark
                        small
                        fixed
                        bottom
                        right
                        @click.stop="addUser = !addUser"
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                </v-fab-transition>
            </template>
            <span>Add new worker or Administrator</span>
        </v-tooltip>

        <v-row class="mx-3">

            <v-col v-for="user in users" class="col-4">
                <v-card class="elevation-4">
                    <v-card-title>
                        <span>{{user.name}}</span>
                    </v-card-title>

                    <v-row class="px-2 text-sm-body-2 pb-3 v-card--hover" no-gutters>

                        <v-col class="col-12 py-1">
                            <v-row no-gutters>
                                <v-col class="col-6">
                                    Email
                                </v-col>
                                <v-col class="col-6">
                                    {{user.email}}
                                </v-col>
                            </v-row>
                        </v-col>

                        <hr class="col-12 grey--text">

                        <v-col class="col-12 py-1">
                            <v-row no-gutters>
                                <v-col class="col-6">
                                    Started Working On:
                                </v-col>
                                <v-col class="col-6">
                                    {{user.created_at}}
                                </v-col>
                            </v-row>
                        </v-col>

                        <hr class="col-12 grey--text">

                        <v-col class="col-12 py-1">
                            <v-row no-gutters>
                                <v-col class="col-6">
                                    Made An Update On:
                                </v-col>
                                <v-col class="col-6">
                                    {{user.updated_at}}
                                </v-col>
                            </v-row>
                        </v-col>

                        <hr class="col-12 grey--text">

                        <v-col class="col-12 py-1">
                            <v-row no-gutters>
                                <v-col class="col-6">
                                    Role
                                </v-col>
                                <v-col class="col-6">
                                    {{ user.admin == true ? 'Administrator' : 'Worker' }}
                                </v-col>
                            </v-row>
                        </v-col>

                        <hr class="col-12">

                        <v-col class="col-12 py-1">
                            <v-row no-gutters>
                                <v-col class="col-6">
                                    Salary
                                </v-col>
                                <v-col class="col-6">
                                    GHCedis {{user.salary}}
                                </v-col>
                            </v-row>
                        </v-col>

                        <hr class="col-12 grey--text">

                        <v-col class="col-12 pt-5">
                            <v-row no-gutters>
                                <v-col class="col-4">
                                    <v-btn
                                           @click="updateProfile(user)"
                                           fab text small
                                    >
                                        <v-icon color="indigo">
                                            mdi-pencil
                                        </v-icon>
                                    </v-btn>
                                </v-col>

                                <v-col color="pink" class="text-white col-4">
                                    <v-btn
                                        small fab fab text
                                        @click="updatePassword(user)"
                                    >
                                        <v-icon
                                        color="pink"
                                        >
                                            mdi-lock
                                        </v-icon>
                                    </v-btn>
                                </v-col>

                                <v-col color="red" class="text-white col-4">
                                    <v-btn
                                        small v-ripple fab text
                                        @click="setRemoveUser(user)"
                                    >
                                        <v-icon color="red">
                                            mdi-delete
                                        </v-icon>
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-col>

                    </v-row>
                </v-card>
            </v-col>

            <!--update profile modal-->
            <v-dialog v-model="show_update_profile" class="ml-5" max-width="500px">
                <v-card>
                    <v-card-text>
                        <v-container>
                            <v-form>
                                <v-card-title class="blue-grey">Update {{editedUser.name}}'s Profile</v-card-title>
                                <v-row class="black--text">

                                    <v-col class="col-12">
                                        <v-text-field label="Name" v-model="editedUser.name"></v-text-field>
                                    </v-col>

                                    <v-col class="col-12">
                                        <v-text-field label="Username" v-model="editedUser.email"></v-text-field>
                                    </v-col>

                                    <v-col class="col-12">
                                        <v-text-field label="Salary" v-model="editedUser.salary"></v-text-field>
                                    </v-col>

                                    <v-col class="col-12">
                                        <v-select
                                            v-model="editedUser.admin"
                                            :items="user_role"
                                            label="User Role"
                                        ></v-select>
                                    </v-col>

                                </v-row>
                            </v-form>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="show_update_profile = !show_update_profile">Cancel</v-btn>
                        <v-btn color="blue darken-1" text @click="saveProfileUpdate">Save</v-btn>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
            </v-dialog>


            <!--update password modal-->
            <v-dialog v-model="show_update_password" class="ml-5" max-width="500px">
                <v-card>
                    <v-card-text>
                        <v-container>
                            <v-form>
                                <v-card-title class="red text-white">Update {{editedPasswordUser.name}}'s Password</v-card-title>
                                <v-row class="black--text">

                                    <v-col class="col-12">
                                        <v-text-field label="Password" v-model="editedPasswordCredentials.pass" ></v-text-field>
                                    </v-col>

                                    <v-col class="col-12">
                                        <v-text-field label="Confirm Password" v-model="editedPasswordCredentials.conf_pass"></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-form>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="show_update_password = !show_update_password">Cancel</v-btn>
                        <v-btn color="blue darken-1" :disabled="disableSavePass"  text @click="savePasswordUpdate">Save</v-btn>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
            </v-dialog>


            <v-dialog v-model="show_confirm_remove_worker" class="ml-5" max-width="500px">
                <v-card>
                    <v-card-text>
                        <v-container>
                            <v-card>
                                <v-card-title class="bg-danger">Remove {{userToRemove.name}} ?</v-card-title>
                            </v-card>
                            <v-row>
                                <v-col class="col-12">
                                    <v-text-field v-model="pass" type="password" label="Enter Password"></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="show_confirm_remove_worker = !show_confirm_remove_worker">Cancel</v-btn>
                        <v-btn color="blue darken-1" :disabled="disableSavePass"  text @click="confirmRemoveUser">Confirm</v-btn>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <!-- confirm removal of user modal -->

        </v-row>

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

    </div>
</template>

<script>
    export default {
        name: "Workers",
        data: ()=>({
            users: [], admins: [], show_update_profile: false, show_update_password: false,
            show_confirm_remove_worker: false, editedUser: {}, editedPasswordUser: {},
            editedPasswordCredentials: {pass: '', conf_pass: '', id: ''}, user_role: ['Administrator', 'Worker'],
            snack: false, snackColor: '', snackText: '',
            disableSavePass: false, disableSaveProfile: false,
            userToRemove: {},
            addUser: false,
            pass: '',
        }),
        methods: {
            updateProfile(user){
                this.show_update_profile = !this.show_update_profile
                this.editedUser = user
            },
            updatePassword(user){
                this.show_update_password = !this.show_update_password
                this.editedPasswordUser = user
                this.editedPasswordCredentials.id = user.id
            },
            savePasswordUpdate(){
                if (this.editedPasswordCredentials.pass === ''
                    || this.editedPasswordCredentials.conf_pass === ''
                    || this.editedPasswordCredentials.conf_pass !== this.editedPasswordCredentials.pass){

                    this.snack = true
                    this.snackColor = 'error'
                    this.snackText = 'Error, please make sure you enter correct password'
                }
                else {
                    axios.post('worker/update-password', {
                        id: this.editedPasswordCredentials.id,
                        password: this.editedPasswordCredentials.pass,
                        password_confirmation: this.editedPasswordCredentials.conf_pass
                    }).then((res)=>{
                        this.snack = true
                        this.snackColor = 'success'
                        this.snackText = res.data['mess']
                        this.show_update_password = false
                        this.editedPasswordCredentials = {id:'', pass: '', conf_pass: ''}
                    })
                }
            },
            saveProfileUpdate(){
                if (this.editedUser.name === '' || this.editedUser.email === '' || this.editedUser.admin === null){
                    this.snack = true
                    this.snackColor = 'error'
                    this.snackText = 'All fields are required'
                    return
                }
                axios.post('worker/update', this.editedUser).then((res)=>{
                    this.snack = true
                    this.snackColor = 'success'
                    this.snackText = res.data.mess
                    this.show_update_profile = false
                    this.editedUser = {}
                    this.fetchUsers()
                })
            },
            setRemoveUser(user){
                this.userToRemove = user
                this.show_confirm_remove_worker = true
            },
            confirmRemoveUser(){
                // check password before deleting user
                axios.post('worker/check-user-password', {password: this.pass}).then((res)=>{
                    if (res.data['result'] === 'match'){
                        axios.post('worker/destroy', {id: this.userToRemove.id}).then((res)=>{
                            this.snack = true
                            this.snackColor = 'success'
                            this.snackText = res.data.mess
                            this.show_confirm_remove_worker = false
                            this.fetchUsers()
                            this.userToRemove = {}
                        })
                    }
                    else if(res.data['result'] === 'not-match'){
                        this.snack = true
                        this.snackColor = 'error'
                        this.snackText = 'Incorrect password, please again'
                    }
                })

            },
            closeAddUser(){
                this.addUser = false
                this.fetchUsers()
            },
            fetchUsers(){
                axios.get('worker/all').then((res)=>{
                    this.users = res.data['users']
                })
            }
        },
        created() {
            this.fetchUsers()
        }
    }
</script>

<style scoped>

</style>
