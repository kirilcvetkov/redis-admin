<script setup>
  import { ref } from 'vue';
  import { usePage } from '@inertiajs/vue3';
  import AppLayout from '@/Layouts/AppLayout.vue';
  import ItemTitle from "@/components/ItemTitle.vue";
  import ItemValue from "@/components/ItemValue.vue";
  import ItemDetails from "@/components/ItemDetails.vue";
  import Alert from '@/Components/Alert.vue';

  const page = usePage();
  const showParts = ref(true);
  const showAlert = ref(false);
  const responseStatus = ref(true);
  const responseMessage = ref('');

  function deleteItem() {
    showAlert.value = true;

    axios.delete(route('delete', { selectedConnection: page.props.selectedConnection, key: page.props.item.key }))
    .then((response) => {
      if (response.data.success) {
        showParts.value = false;
        responseStatus.value = true;
        responseMessage.value = response.data.message;
      } else {
        responseMessage.value = response.data.error || 'Error';
        responseStatus.value = false;
      }
    })
    .catch((response) => {
      responseMessage.value = response.data.error || 'Error';
      responseStatus.value = false;
    });
  }
</script>

<template>
  <AppLayout title="Item">
    <template #header>
      <Alert
      v-show="showAlert"
      @click="showAlert = false"
      :status="responseStatus"
      >
        {{ responseMessage }}
      </Alert>
      <ItemTitle
      v-show="showParts"
      :key="$page.props.item"
      :id="$page.props.item.key"
      @delete="deleteItem"
      />
    </template>

    <div v-show="showParts">
      <ItemDetails :key="$page.props.item" :item="$page.props.item" />
      <ItemValue :key="$page.props.item" :item="$page.props.item" />
    </div>
  </AppLayout>
</template>
