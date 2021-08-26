<template>
  <div>
    <div
      class="max-w-7xl mx-auto p-6 flex items-center flex-col h-full min-h-screen"
    >
      <div
        class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-green-700 bg-green-100 border border-green-300"
      >
        <div>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="100%"
            height="100%"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-check-circle w-5 h-5 mx-2"
          >
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
          </svg>
        </div>
        <div class="text-xl font-normal max-w-full flex-initial">
          Loja conectada com sucesso!
        </div>
        <div class="flex flex-auto flex-row-reverse">
          <div>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="100%"
              height="100%"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="feather feather-x cursor-pointer hover:text-green-400 rounded-full w-5 h-5 ml-2"
            >
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- <div
      v-if="authorizationCode"
      class="max-w-7xl mx-auto p-6 flex items-center flex-col h-full min-h-screen"
    >
      <h2 class="">
        Anote este código: <br />
        {{ authorizationCode }}
      </h2>
      <a
        :href="verificationUrl"
        target="_new"
        class="rounded-md bg-red-500 text-white px-8 py-2 mx-auto my-2 hover:bg-red-600"
        >Clique aqui</a
      >
    </div>

    <div
      v-else
      class="max-w-7xl mx-auto p-6 flex items-center flex-col h-full min-h-screen"
    >
      <h2 class="">
        Conecte a sua loja do Ifood com o MandaVir e receba os seus pedidos
        aqui.
      </h2>
      <a
        href="/ifood/auth"
        class="rounded-md bg-red-500 text-white px-8 py-2 mx-auto my-2 hover:bg-red-600"
        >Conectar ao Ifood</a
      >
    </div> -->
  </div>
</template>

<script>
export default {
  props: {
    merchant: Object,
  }
};
</script>
