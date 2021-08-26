<template>
  <div>
    <div
      v-if="ifood_authorization_token.access_token"
      class="max-w-7xl mx-auto p-10 flex items-center justify-center flex-col"
    >
      <h3 class="text-3xl font-black">✔ Loja conectada ao Ifood</h3>
    </div>

    <div
      v-else
      class="max-w-7xl mx-auto p-10 flex items-center justify-center flex-col"
    >
      <h3 class="text-3xl font-black">Conectar ao Ifood</h3>
      <p>Conecte a sua loja e receba os pedidos do Ifood por aqui</p>
    </div>

    <hr />

    <div
      class="
        max-w-6xl
        mx-auto
        px-10
        flex flex-col
        md:flex-row
        h-full
        md:space-x-10
      "
    >
      <div class="flex flex-col md:flex-row">
        <ul>
          <li class="text-2xl font-black">
            Código do usuário
            <strong v-if="ifood_authorization_token.user_code">✔</strong>
          </li>
          <li class="text-2xl font-black">
            Código de autorização
            <strong v-if="ifood_authorization_token.authorization_code"
              >✔</strong
            >
          </li>
          <li class="text-2xl font-black">
            Token de acesso
            <strong v-if="ifood_authorization_token.access_token">✔</strong>
          </li>
        </ul>
      </div>

      <div class="p-10 flex flex-col w-full md:w-1/2 mb-10">
        <h2
          class="
            text-center
            justify-center
            items-center
            flex
            text-xl
            uppercase
            mb-4
          "
        >
          <strong class="opacity-50 mr-2">1.</strong> Anote este código:
        </h2>
        <span
          class="
            text-center
            border border-gray-200
            rounded-md
            px-5
            py-2
            block
            my-2
            w-full
            text-4xl
          "
          >{{ ifood_authorization_token.user_code }}</span
        >
        <br />
        <ul class="text-sm px-5 list-disc">
          <li>
            Acesse o
            <a
              :href="ifood_authorization_token.verification_url"
              target="_blank"
              >portal do parceiro</a
            >
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
            :href="ifood_authorization_token.verification_url_complete"
            target="_new"
            class="
              rounded-md
              bg-red-500
              text-white
              px-8
              py-2
              mx-auto
              hover:bg-red-600
            "
            >Clique aqui</a
          >
        </p>
      </div>

      <div class="p-10 text-center flex flex-col w-full md:w-1/2">
        <h2
          class="
            text-center
            justify-center
            items-center
            flex
            text-xl
            uppercase
            mb-4
          "
        >
          <strong class="opacity-50 mr-2">2.</strong> Insira o código do Ifood
          aqui:
        </h2>
        <form
          action="/ifood/auth"
          method="post"
          @submit.prevent="sendAuthorizationCode"
        >
          <input
            type="text"
            required
            placeholder="_ _ _ _ - _ _ _ _"
            name="authorization_code"
            class="
              text-center
              border border-gray-500
              rounded-md
              px-5
              py-2
              block
              my-2
              w-full
              text-4xl
            "
            v-model="authorization_code"
          />
          <button
            type="submit"
            class="
              rounded-md
              bg-red-500
              text-white
              px-8
              py-2
              mx-auto
              hover:bg-red-600
              w-full
            "
          >
            Enviar
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    ifood_authorization_token: Object,
  },
  data() {
    return {
      authorization_code: "",
      access_token: "",
    };
  },
  methods: {
    sendAuthorizationCode() {
      if (this.authorization_code.length < 8) {
        return;
      }

      this.fetchNewToken();
    },
    fetchNewToken() {
      // prepare data
      var formData = new FormData();
      formData.append("authorizationCode", this.authorization_code);
      formData.append(
        "authorizationCodeVerifier",
        this.ifood_authorization_token.authorization_code_verifier
      );
      formData.append("_token", this.$page.props.csrf_token);

      // fetch token
      return fetch(`/api/ifood/auth`, {
        method: "POST",
        body: formData,
      })
        .then((res) => {
          res.json().then(({ original }) => {
            if (original.access_token && original.refresh_token) {
              window.location.href = `/ifood`;
            }
          });
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
