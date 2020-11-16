<template>
    <div>

        <v-fab-transition>
            <v-btn
                color="pink"
                fab
                dark
                small
                fixed
                bottom
                right
                @click.stop="show_cart = !show_cart"
            >
                <v-icon>mdi-cart</v-icon>
            </v-btn>
        </v-fab-transition>

        <cart v-on:refreshItems="fetchItems" v-on:hideCart="show_cart = !show_cart" v-if="show_cart"></cart>

        <v-container>
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search Item"
                single-line
                hide-details
                class="w-50"
            ></v-text-field>
            <v-divider></v-divider>
        </v-container>
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

            <template v-slot:item.quantity_to_sell="props">
                <v-edit-dialog
                    :return-value.sync="props.item.quantity_to_sell"
                    @save="addToCart(props.item.id, props.item.quantity_to_sell, props.item.quantity)"
                >
                    {{ props.item.quantity_to_sell }}
                    <template v-slot:input>
                        <v-text-field
                            :disabled="checkQuantity(props.item.quantity)"
                            v-model="props.item.quantity_to_sell"
                            :rules="[]"
                            label="Quantity"
                            single-line
                            counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

        </v-data-table>
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
        name: "SelL",
        data: ()=>({
            items: [],
            search: '',
            loading: false,
            snack: false,
            snackColor: '',
            snackText: '',
            headers: [
                {
                    text: 'Name',
                    align: 'start',
                    value: 'name',
                },
                { text: 'Price', value: 'selling_price' },
                { text: 'Store Box', sortable:false, value: 'store_box' },
                { text: 'Quantity In Stock', value: 'quantity' },
                { text: 'Quantity To Sell', sortable:false, value: 'quantity_to_sell' },
            ],
            show_cart: false,
            disable: true,
        }),
        methods: {
            addToCart (id, quantity_to_sell, item_quantity) {
                if (quantity_to_sell === '' || quantity_to_sell == null
                    || isNaN(quantity_to_sell)){
                    this.snack = true
                    this.snackColor = 'error'
                    this.snackText = 'invalid quantity'
                    return
                }
                let data = {
                    id: id,
                    quantity: quantity_to_sell
                }
                axios.post('cart/add', data).then((res)=>{
                    let ret = res.data
                    if (ret['type'] === 'error'){
                        this.snack = true
                        this.snackColor = 'error'
                        this.snackText = res.data.mess
                    }
                    else if (ret['type'] === 'success'){
                        this.snack = true
                        this.snackColor = 'success'
                        this.snackText = res.data.mess
                    }

                })

            },

            fetchItems(){
                this.loading = true
                axios.post('item/index', {type: 'all'}).then((res)=>{
                    this.items = res.data['items']
                    this.loading = false
                })

            },

            checkQuantity(quantity){
                let disable = true
                if (quantity < 1){
                    disable = true
                }
                else {
                    disable = false
                }
                return disable
            }
        },
        created() {
            this.fetchItems()
        }
    }
</script>

<style scoped>
    .fb{
        /*margin-top: 5%;*/
    }
</style>
