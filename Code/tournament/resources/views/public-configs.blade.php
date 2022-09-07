<script>
    window.Lang = {
        status_round: {
            nao_iniciada: "Não Iniciado",
            em_andamento: "Em Andamento",
            parada: "Parado",
            concluida: "Concluído"
        },

        nome_golpes: {
            vitoria: "Vitória (Round)",
            ippon: "Ippon",
            waza_ari: "Waza-Ari",
            yuko: "Yuko",
            koka: "Koka",
            yusei_gashi: "Yusei-Gashi"
        },

        pontos_golpes: {
            vitoria: "",
            ippon: "Vence Round",
            waza_ari: "+10 Pontos",
            yuko: "+6 Pontos",
            koka: "+4 Pontos",
            yusei_gashi: "+2 Pontos"
        }
    };

    window.Urls = {
        round_url: '{{ url('admin/torneio/round') }}',
        round_public_api: '{{ url('round/api') }}',
        round_api: '{{ url('admin/round/api') }}',
        batalha_url: '{{ url('admin/torneio/batalhas') }}',
        round_public_url: '{{ url('round') }}',
        batalha_public_url: '{{ url('ringues') }}',
        watch_ringue_url: '{{ url('assistir-ringue') }}'
    };
</script>