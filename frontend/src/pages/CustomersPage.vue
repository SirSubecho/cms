<template>
  <q-page class="q-pa-md">
    <q-table
      title="Kundenübersicht"
      :rows="rows"
      :columns="columns"
      row-key="id"
      v-model:pagination="pagination"
      :loading="loading"
      :filter="filter"
      @request="onRequest"
      binary-state-sort
    >
      <template v-slot:top-right>
        <q-input
          dense
          debounce="300"
          v-model="filter"
          placeholder="Suchen..."
          class="q-mr-md"
        >
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>

        <q-btn
          color="primary"
          icon-right="add"
          label="Neuen Kunden anlegen"
          @click="openCreateDialog"
        />
      </template>

      <template v-slot:body-cell-actions="props">
        <q-td :props="props">
          <q-btn
            flat
            dense
            round
            color="primary"
            @click="editCustomer(props.row)"
          >
            <PencilIcon style="width: 20px; height: 20px;" />
            <q-tooltip>Bearbeiten</q-tooltip>
          </q-btn>

          <q-btn
            flat
            dense
            round
            color="negative"
            @click="confirmDelete(props.row)"
          >
            <TrashIcon style="width: 20px; height: 20px;"/>
            <q-tooltip>Löschen</q-tooltip>
          </q-btn>
        </q-td>
      </template>
    </q-table>

    <q-dialog v-model="dialogOpen" persistent>
      <q-card style="min-width: 800px">
        <q-card-section>
          <div class="text-h6">
            {{ editMode ? `${form.first_name} ${form.name} bearbeiten` : 'Neuen Kunden anlegen' }}
          </div>
        </q-card-section>

        <q-card-section class="q-pt-none">
          <q-form @submit="saveCustomer" class="q-gutter-md">
            <div class="row q-col-gutter-sm">
              <div class="col">
                <q-input
                  v-model="form.first_name"
                  label="Vorname"
                  outlined
                  hide-bottom-space
                  :rules="[val => !!val || 'Vorname wird benötigt']"
                />
              </div>

              <div class="col">
                <q-input
                  v-model="form.name"
                  label="Nachname"
                  outlined
                  hide-bottom-space
                  :rules="[val => !!val || 'Nachname wird benötigt']"
                />
              </div>
            </div>

            <div class="row q-col-gutter-sm">
              <div class="col">
                <q-input
                  v-model="form.email"
                  label="E-Mail"
                  type="email"
                  outlined
                  hide-bottom-space
                  :rules="[val => !!val || 'E-Mail wird benötigt']"
                />
              </div>

              <div class="col">
                <q-input
                  v-model="form.phone"
                  label="Telefon"
                  outlined />
              </div>
            </div>

            <div class="row q-col-gutter-sm">
              <div class="col">
                <q-input
                  v-model="form.street"
                  label="Anschrift"
                  outlined
                />
              </div>
            </div>

            <div class="row q-col-gutter-sm">
              <div class="col-4">
                <q-input
                  v-model="form.postal_code"
                  label="PLZ" outlined
                />
              </div>
              <div class="col-8">
                <q-input
                  v-model="form.city"
                  label="Stadt"
                  outlined
                />
              </div>
            </div>

            <div class="row justify-end q-gutter-sm">
              <q-btn
                flat
                label="Abbrechen"
                @click="dialogOpen = false"
              />

              <q-btn
                type="submit"
                color="primary"
                :label="editMode ? 'Aktualisieren' : 'Erstellen'"
                :loading="saving"
              />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </q-page>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useQuasar } from 'quasar'
import api from 'src/services/api'
import { PencilIcon, TrashIcon } from '@heroicons/vue/24/outline'

const $q = useQuasar()

const columns = [
  {
    name: 'id',
    label: 'ID',
    field: 'id',
    sortable: true,
    align: 'left'
  },
  {
    name: 'name',
    label: 'Nachname',
    field: 'name',
    sortable: true,
    align: 'left'
  },
  {
    name: 'first_name',
    label: 'Vorname',
    field: 'first_name',
    sortable: true,
    align: 'left'
  },
  {
    name: 'email',
    label: 'E-Mail',
    field: 'email',
    sortable: true,
    align: 'left'
  },
  {
    name: 'phone',
    label: 'Telefon',
    field: 'phone',
    align: 'left'
  },
  {
    name: 'street',
    label: 'Anschrift',
    field: 'street',
    align: 'left'
  },
  {
    name: 'postal_code',
    label: 'PLZ',
    field: 'postal_code',
    align: 'left'
  },
  {
    name: 'city',
    label: 'Stadt',
    field: 'city',
    align: 'left'
  },
  {
    name: 'actions',
    label: 'Aktionen',
    field: 'actions',
    align: 'right'
  }
]

const rows = ref([])
const filter = ref('')
const loading = ref(false)
const pagination = ref({
  sortBy: 'id',
  descending: false,
  page: 1,
  rowsPerPage: 10,
  rowsNumber: 0
})

const dialogOpen = ref(false)
const editMode = ref(false)
const saving = ref(false)
const form = ref({
  id: null,
  name: '',
  first_name: '',
  email: '',
  phone: '',
  street: '',
  postal_code: '',
  city: ''
})

async function onRequest(props) {
  const { page, rowsPerPage, sortBy, descending } = props.pagination
  const filter = props.filter

  loading.value = true

  try {
    const response = await api.get('/customers', {
      params: {
        page,
        per_page: rowsPerPage,
        sort_by: sortBy,
        sort_order: descending ? 'desc' : 'asc',
        search: filter
      }
    })

    rows.value = response.data.data
    pagination.value.rowsNumber = response.data.total
    pagination.value.page = response.data.current_page
    pagination.value.rowsPerPage = response.data.per_page
    pagination.value.sortBy = sortBy
    pagination.value.descending = descending
  } catch (error) {
    console.error('Failed to load customers:', error)
    $q.notify({
      type: 'negative',
      message: '<strong>Fehler!</strong> Kunden konnten nicht geladen werden',
      html: true
    })
  } finally {
    loading.value = false
  }
}

function openCreateDialog() {
  editMode.value = false
  form.value = {
    id: null,
    name: '',
    first_name: '',
    email: '',
    phone: '',
    street: '',
    postal_code: '',
    city: ''
  }
  dialogOpen.value = true
}

function editCustomer(customer) {
  editMode.value = true
  form.value = { ...customer }
  dialogOpen.value = true
}

async function saveCustomer() {
  saving.value = true

  try {
    if (editMode.value) {
      await api.put(`/customers/${form.value.id}`, form.value)
      $q.notify({
        type: 'positive',
        message: `<strong>${form.value.first_name} ${form.value.name}</strong>erfolgreich aktualisiert`,
        html: true
      })
    } else {
      await api.post('/customers', form.value)
      $q.notify({
        type: 'positive',
        message: `<strong>${form.value.first_name} ${form.value.name}</strong> erfolgreich angelegt`,
        html: true
      })
    }

    dialogOpen.value = false
    onRequest({ pagination: pagination.value })
  } catch (error) {
    $q.notify({
      type: 'negative',
      message: error.response?.data?.message || '<strong>Fehler!</strong> Kunde konnte nicht gespeichert werden',
      html: true
    })
  } finally {
    saving.value = false
  }
}

function confirmDelete(customer) {
  $q.dialog({
    title: 'Löschen bestätigen',
    message: `Sind Sie sicher, dass Sie <strong>${customer.first_name} ${customer.name}</strong> löschen möchten?`,
    html: true,
    cancel: {
      label: 'Abbrechen',
      color: 'grey',
      flat: true,
    },
    ok: {
      label: 'Löschen',
      color: 'negative',
      flat: true
    },
    persistent: true
  }).onOk(async () => {
    try {
      await api.delete(`/customers/${customer.id}`)
      $q.notify({
        type: 'positive',
        message: `<strong>${customer.first_name} ${customer.name}</strong> erfolgreich gelöscht`,
        html: true

      })
      onRequest({ pagination: pagination.value })
    } catch (error) {
      console.error('Failed to delete customer:', error)
      $q.notify({
        type: 'negative',
        message: '<strong>Fehler!</strong> Kunde konnte nicht gelöscht werden',
        html: true
      })
    }
  })
}

onMounted(() => {
  onRequest({
    pagination: pagination.value,
    filter: undefined
  })
})
</script>
