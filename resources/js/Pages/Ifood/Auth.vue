<template>
  <div>
    <div
      class="max-w-7xl mx-auto p-10 flex items-center justify-center flex-col"
    >
      <h3 class="text-3xl font-black">Conectar ao Ifood</h3>
      <p>Conecte a sua loja e receba os pedidos do Ifood por aqui</p>
    </div>

    <hr />

    <div
      class="max-w-6xl mx-auto px-10 flex flex-col md:flex-row h-full md:space-x-10"
    >
      <div class="p-10 flex flex-col w-full md:w-1/2 mb-10">
        <h2 class="text-center justify-center items-center flex flex-col">
          <span
            class="rounded-full border-2 border-gray-200 font-black text-gray-200 w-10 h-10 items-center leading-none justify-center flex mb-3"
            >1</span
          >
          Anote este código:
        </h2>
        <span
          class="text-center border border-gray-200 rounded-md px-5 py-2 block my-2 w-full text-4xl"
          >{{ client.authorization_code.user_code }}</span
        >
        <br />
        <ul class="text-sm px-5 list-disc">
          <li>
            Acesse o
            <a :href="client.authorization_code.verification_url" target="_blank">portal do parceiro</a>
            Ifood
          </li>
          <li>
            Em Aplicativos, clique em
            <strong>Ativar aplicativo por código</strong>
          </li>
          <li>Insira o código acima</li>
        </ul>

        <hr class="my-3" />

        <p class="text-center">
          ou
          <br />
          <br />
          <a
            :href="client.authorization_code.verification_url_complete"
            target="_new"
            class="rounded-md bg-red-500 text-white px-8 py-2 mx-auto hover:bg-red-600"
            >Clique aqui</a
          >
        </p>
      </div>

      <div class="p-10 text-center flex flex-col w-full md:w-1/2">
        <h2 class="text-center justify-center items-center flex flex-col">
          <span
            class="rounded-full border-2 border-gray-200 font-black text-gray-200 w-10 h-10 items-center leading-none justify-center flex mb-3"
            >2</span
          >
          Insira o código do Ifood aqui:
        </h2>
        <form action="/ifood/auth" method="post" @submit.prevent="sendAuthCode">
          <input
            type="text"
            placeholder="_ _ _ _ - _ _ _ _"
            name="authorizationCode"
            class="text-center border border-gray-500 rounded-md px-5 py-2 block my-2 w-full text-4xl"
            v-model="authorizationCode"
          />
          <button
            type="submit"
            class="rounded-md bg-red-500 text-white px-8 py-2 mx-auto hover:bg-red-600 w-full"
          >
            Enviar
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import IfoodHeader from "./Header";

export default {
  props: {
    client: Object
  },
  data() {
    return {
      authorizationCode: "",
    };
  },
  components: {
    IfoodHeader,
  }, 
  methods: {
    sendAuthCode() {
      this.$inertia
        .post("/ifood/auth", {
          authorizationCode: this.authorizationCode,
          authorizationCodeVerifier: this.client.authorization_code.authorization_code_verifier,
          //   verificationUrl: this.verificationUrl,
          //   verificationUrlComplete: this.verificationUrlComplete,
          _token: this.$page.props.csrf_token,
        })
        .then((resp) => {
          debugger;
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
