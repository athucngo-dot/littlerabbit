export default function dashboardAddress() {

    function notifyValidationMsg(errors) {
        let items = '';

        Object.values(errors).forEach(fieldErrors => {
            fieldErrors.forEach(err => items += `<li>${err}</li>`);
        });
        popup.error(`<ul class='text-left list-disc pl-5 space-y-1'>${items}</ul>`);

        return;
    }

    return {
        addresses: [],
        editing: null,
        editingBackup: {},

        // Initialize the component
        async init() {
            console.log("dashboardAddress loaded");

            // fetch customer addresses
            await this.fetchAddresses();
        },

        async fetchAddresses() {
            console.log("fetchAddresses");
            try {
                const res = await fetch('/customer/addresses', {
                    headers: { 'Accept': 'application/json' }
                });

                const data = await res.json();
                this.addresses = data.addresses ?? [];

            } catch (err) {
                popup.error("Failed to load addresses.");
            }
        },

        openEdit(id) {
            this.editing = id;

            const original = this.addresses.find(a => a.id === id);
            this.editingBackup[id] = JSON.parse(JSON.stringify(original));
        },

        cancelEdit() {
            if (this.editing) {
                const index = this.addresses.findIndex(a => a.id === this.editing);

                if (index !== -1 && this.editingBackup[this.editing]) {
                    // restore from backup
                    this.addresses[index] = JSON.parse(JSON.stringify(this.editingBackup[this.editing]));
                    delete this.editingBackup[this.editing]; // clean up
                }
            }

            this.editing = null;
        },

        // update address
        async saveAddress(address) {
            try {
                const res = await fetch(`/customer/addresses/${address.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify(address)
                });

                const data = await res.json();

                // Handle validation errors
                if (!res.ok && res.status === 422) {
                    notifyValidationMsg(data.errors || {});
                    return;
                }

                if (res.ok) {
                    popup.success(data.message || 'Address updated.');
                    this.editing = null;
                } else {
                    popup.error(data.message || 'Update failed.');
                }
            } catch (err) {
                popup.error('Network error updating address.');
            }
        },

        // delete address
        async deleteAddress(id) {
            popup.confirm(
                "Delete Address",
                "This will be permanently delete this address. Do you confirm to do that ?",
                async () => {
                    try {
                        const res = await fetch(`/customer/addresses/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                            }
                        });


                        const data = await res.json();

                        if (res.ok) {
                            this.addresses = this.addresses.filter(a => a.id !== id);
                            popup.success('Address deleted.');
                        } else {
                            popup.error(data.message || 'Delete failed.');
                        }

                    } catch (err) {
                        popup.error('Network error deleting address.');
                    }
                }
            );
        },

        // add new address
        async addAddress(address) {
            try {
                const res = await fetch(`/customer/addresses`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify(address)
                });

                const data = await res.json();

                // Handle validation errors
                if (!res.ok && res.status === 422) {
                    notifyValidationMsg(data.errors || {});
                    return;
                }

                if (res.ok) {
                    this.addresses.push(data.address);

                    // reset form
                    this.new_street = '';
                    this.new_city = '';
                    this.new_province = '';
                    this.new_postal_code = '';
                    this.new_country = '';

                    // close form
                    this.open = false;

                    popup.success(data.message || 'Address added.');
                } else {
                    popup.error(data.message || 'Add new address failed.');
                }

            } catch (err) {
                popup.error('Network error updating address.');
            }
        },

        // submit new address
        async submitNewAddress() {
            const address = {
                street: this.new_street,
                city: this.new_city,
                province: this.new_province,
                postal_code: this.new_postal_code,
                country: this.new_country
            };

            await this.addAddress(address);
        },
    };
}
