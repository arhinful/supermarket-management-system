<template>
    <div>
        <v-form v-model="form_valid" ref="form">
            <v-container>
                <v-row>
                    <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field
                            v-model="item_name"
                            :rules="nameRules"
                            label="Item Name"
                            required
                        ></v-text-field>
                    </v-col>

                    <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field
                            v-model="purchase_price"
                            :rules="priceRules"
                            label="Purchase Price"
                            required
                        ></v-text-field>
                    </v-col>

                    <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field
                            v-model="selling_price"
                            :rules="priceRules"
                            label="Selling Price"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field
                            v-model="quantity"
                            :rules="quantityRules"
                            label="Quantity"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field
                            v-model="store_box"
                            :rules="storeBoxRules"
                            label="Store Box/Area"
                        >

                        </v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-btn
                            @click="submit"
                            color="success"
                            class="mr-4"
                        >Add Item</v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-form>
    </div>
</template>

<script>
    export default {
        name: "AddToStock",
        data: ()=>({
            item_name: '',
            nameRules: [v => !!v || 'Name is required',],
            purchase_price: '',
            selling_price: '',
            priceRules: [v => !!v || 'This field is required',],
            store_box: '',
            storeBoxRules: [],
            quantity: '',
            quantityRules: [],

            form_valid: false
        }),
        methods: {
            submit () {
                if(this.$refs.form.validate()){
                    let item = {
                        name: this.item_name,
                        purchase_price: this.purchase_price,
                        selling_price: this.selling_price,
                        store_box: this.store_box,
                        quantity: this.quantity
                    }
                    console.log(item)
                    axios.post('item/store', item)
                    .then((res)=>{
                        console.log(res)
                        alert(res.data['success'])
                        this.$refs.form.reset();
                    })
                }
            },
        },
    }
</script>

<style scoped>

</style>
