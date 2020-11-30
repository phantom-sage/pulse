<template>
    <div class="container mx-auto my-8">
        <div class="flex flex-wrap">

            <div class="w-full">
                <input type="search" @keydown="fetchMedicines" v-model="medicineName" class="rounded py-2 px-3 border w-full" placeholder="Medicine name">
            </div>

            <div class="w-full">
                <div class="flex flex-wrap">

                    <div class="w-6/12 mx-auto text-center my-3">
                        <input v-model="medicineSearchType" value="trade" name="medicine" type="radio" id="trade" checked>
                        <label for="scientist" class="block">
                        Trade
                        </label>
                    </div>

                    <div class="w-6/12 mx-auto text-center my-3">
                        <input v-model="medicineSearchType" value="scientist" name="medicine" type="radio" id="scientist">
                        <label class="block" for="scientist">
                        Scientist
                        </label>
                    </div>

                </div>
            </div>

            <div class="divide-y bg-black"></div>

            <div v-for="medicine in medicines.data" class="w-full sm:w-6/12 md:4/12 lg:3/12 xl:3/12">
                <div class="border rounded shadow-sm m-2 p-2">
                    <h3>Trade name: {{ medicine.trade_name }}</h3>
                    <h3>Scientist name: {{ medicine.scientist_name }}</h3>
                    <small>{{ medicine.amount }} mg</small>
                    <p v-if="medicine.pharmacy !== null">
                        <strong>Pharmacy:</strong>
                        {{ medicine.pharmacy.name }}
                    </p>
                    <div class="divide-y bg-black my-2"></div>
                    <p>
                        <strong>Location:</strong>
                        <a class="px-3 py-1 bg-green-600 text-white rounded font-bold text-lg" href="#">Show in map</a>
                    </p>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'SearchMedicine',
    data() {
        return {
            medicineName: '',
            medicineSearchType: 'trade',
            medicines: [],
        }
    },
    methods: {
        fetchMedicines() {
        console.log(`${this.medicineSearchType}`)
            axios.post(`/api/medicine/all`, {
                medicineSearchType: this.medicineSearchType,
                medicineName: this.medicineName,
            }, {
                headers: {
                    'Accept': 'application/json',
                }
            }).then(data => {
                this.medicines = data.data
                console.log(this.medicines)
            })
            .catch(error => console.error(error))
        }
    },
}
</script>
