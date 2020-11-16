
<template>
    <div>
        <!--Success Alert-->
        <v-snackbar
            v-model="alertSuccess"
            :timeout="3000"
            color="success"
        >
            {{ successMessage }}

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

        <!-- Edit Dialog -->
        <v-dialog
            v-model="dialogEdit"
            max-width="800px"
            width="800px"
        >
            <v-card>
                <v-card-title>
                    <span class="headline">EDIT ITEM {{itemToEditName}}</span>
                </v-card-title>

                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col
                                cols="12"
                                sm="6"
                                md="4"
                            >
                                <v-text-field
                                    v-model="editedItem.name"
                                    label="Item Name"
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="4"
                            >
                                <v-text-field
                                    v-model="editedItem.purchase_price"
                                    label="Purchase Price"
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="4"
                            >
                                <v-text-field
                                    v-model="editedItem.selling_price"
                                    label="Selling Price"
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="4"
                            >
                                <v-text-field
                                    v-model="editedItem.quantity"
                                    label="Quantity"
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="4"
                            >
                                <v-text-field
                                    v-model="editedItem.store_box"
                                    label="Store Box"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="closeEdit"
                    >
                        Cancel
                    </v-btn>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="saveEdit"
                        :disabled="editedItem.name === ''
                        || editedItem.purchase_price === ''
                        || editedItem.selling_price === '' "
                    >
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- Delete Dialog -->
        <v-dialog v-model="dialogDelete" class="ml-5" max-width="500px">
            <v-card>
                <v-card-title>Are you sure you want to delete {{itemToDeleteName}} ?</v-card-title>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="confirmDelete">OK</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-card>
            <v-card-title>
                ITEMS OUT OF STOCK
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search Item"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="items"
                :items-per-page="15"
                class="elevation-3"
                :search="search"
                :loading="loading"
                loading-text="Loading Items... Please wait"
                :footer-props="{
                showFirstLastPage: true,
                firstIcon: 'mdi-arrow-collapse-left',
                lastIcon: 'mdi-arrow-collapse-right',
                prevIcon: 'mdi-minus',
                nextIcon: 'mdi-plus'
            }"
                dark
                dense
            >
                <template v-slot:item.actions="{ item }">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-icon
                                small
                                class="mr-2"
                                @click="editItem(item)"
                                v-bind="attrs"
                                v-on="on"
                            >
                                mdi-pencil
                            </v-icon>
                        </template>
                        <span>edit</span>
                    </v-tooltip>

                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-icon
                                small
                                @click="deleteItem(item)"
                                color="red darken-2"
                                v-bind="attrs"
                                v-on="on"
                            >
                                mdi-delete
                            </v-icon>
                        </template>
                        <span>delete</span>
                    </v-tooltip>
                    <router-link v-bind:to="'/item/show/'+item.id">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-icon
                                    small
                                    @click=""
                                    color="blue darken-2"
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    mdi-eye
                                </v-icon>
                            </template>
                            <span>view more...</span>
                        </v-tooltip>
                    </router-link>

                </template>
            </v-data-table>

        </v-card>

    </div>
</template>

<script>
    export default {
        name: "OutStcoks",
        data: ()=>({
            items: [],
            loading: true,
            search: '',
            headers: [
                {
                    text: 'Name',
                    align: 'start',
                    value: 'name',
                },
                { text: 'Purchase Price', value: 'purchase_price' },
                { text: 'Selling Price', value: 'selling_price' },
                { text: 'Quantity', value: 'quantity' },
                { text: 'Store Box', value: 'store_box' },
                { text: 'Actions', value: 'actions', sortable: false },
            ],
            editedItem: {},
            deletedItem: {},
            dialogDelete: false,
            dialogEdit: false,
            itemToDeleteName: '',
            itemToEditName: '',
            alertSuccess: false,
            successMessage: '',
        }),

        methods: {
            closeEdit () {
                this.dialogEdit = false
                this.editedItem = Object.assign({}, {})
            },
            editItem (item) {
                this.itemToEditName = item.name
                this.dialogEdit = true
                this.editedItem = item
            },
            saveEdit(){
                axios.post('item/update', this.editedItem).then((res)=>{
                    console.log(res.data['success'])
                    this.dialogEdit = false
                    this.fetchItems()
                    this.showSuccess(res.data['success'])
                })
            },
            deleteItem (item) {
                this.deletedItem = item
                this.itemToDeleteName = item.name
                this.dialogDelete = true
            },
            closeDelete(){
                this.dialogDelete = false
                this.deletedItem = Object.assign({}, {})
            },
            confirmDelete(){
                console.log(this.deletedItem.id)
                axios.post('item/destroy',{id: this.deletedItem.id}).then((res)=>{
                    this.fetchItems()
                    this.showSuccess(res.data['success'])
                    this.dialogDelete = false
                    this.deletedItem = Object.assign({}, {})
                })
            },
            fetchItems(){
                // fetch items
                let data_ = {type: 'out'}
                this.loading = true
                let items = axios.post('item/index', data_).then((res)=>{
                    this.items = res.data['items']
                    this.loading = false
                })
            },
            showSuccess(message){
                this.successMessage = message
                this.alertSuccess = true
                setTimeout(()=>{
                    this.alertSuccess = false
                }, 3000)
            },

        },
        mounted() {

        },
        created() {
            this.fetchItems()
        }
    }
</script>

<style scoped>

</style>
