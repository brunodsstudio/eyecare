<template></template>
<script>
import jsPDF from "jspdf";
import { autoTable } from "jspdf-autotable";

export default {
  props: {
    idPacote: {
      type: [Number, String],
      required: true,
    },
    
  },
  data() {
    return {
      paciente: { nome: "João da Silva", cpf: "123.456.789-00" },
      medico: { nome: "Dra. Maria Oliveira", crm: "CRM-SP 123456" },
      logoUrl: "http://"+window.location.host + "/images/eyelogo.jpg",
      dados: null,
      lastPrint:null
    };
  },
  watch: {
    idPacote: {
      immediate: true,
      async handler(novoId) {
        if (novoId) {
          await this.carregarPdf(novoId);
          if(this.lastPrint !== this.idPacote){
            this.carregarPdf()
            this.gerarPDF();
            this.dados=  null,
            this.lastPrint = this.idPacote
          }
          
        }
      },
    },
  },
  methods: {
    async gerarPDF() {
      if (!this.dados) return;

      const doc = new jsPDF();
      const margem = 15;

      const drawHeader = () => {
        doc.setFontSize(12);
        doc.text(`Paciente: ${this.paciente.nome}`, margem, 20);
        doc.text(`CPF: ${this.paciente.cpf}`, margem, 28);
        doc.text(`Médico: ${this.medico.nome}`, margem, 36);
        doc.addImage(this.logoUrl, "PNG", 160, 10, 35, 20);
      };

      const drawFooter = () => {
        const data = new Date().toLocaleDateString("pt-BR", {
          weekday: "long",
          year: "numeric",
          month: "long",
          day: "numeric",
        });
        doc.setFontSize(10);
        doc.text(`${data}`, margem, 285);
        doc.text(`${this.medico.nome} - ${this.medico.crm}`, margem, 292);
      };

      // Página 1
      drawHeader();
      doc.setFontSize(14);
      doc.text(`Pacote: ${this.dados.header.name}`, margem, 55);
      doc.setFontSize(12);
      doc.text(`Observações: ${this.dados.header.observations}`, margem, 65);
      doc.text(`Criado em: ${this.dados.header.created_at}`, margem, 75);
      drawFooter();
      doc.addPage();

      // Grupos
      Object.keys(this.dados).forEach((grupo) => {
        if (grupo === "header" || grupo === "Exames Avulsos") return;

        drawHeader();
        doc.setFontSize(14);
        doc.text(grupo, margem, 55);

        const rows = Object.values(this.dados[grupo]).map((e) => [
          e.id,
          e.laterality,
          e.comment,
        ]);

        autoTable(doc, {
          head: [["Nome", "Lateralidade", "Comentário"]],
          body: rows,
          startY: 65,
          margin: { left: margem },
          styles: { fontSize: 10 },
        });

        drawFooter();
        doc.addPage();
      });

      // Exames Avulsos
      const avulsos = this.dados["Exames Avulsos"] || {};
      Object.keys(avulsos).forEach((key, index) => {
        const exame = avulsos[key];
        drawHeader();
        doc.setFontSize(14);
        doc.text("Exame Avulso", margem, 55);
        autoTable(doc, {
          head: [["Nome", "Lateralidade", "Comentário"]],
          body: [[exame.id, exame.laterality, exame.comment]],
          startY: 65,
          margin: { left: margem },
          styles: { fontSize: 10 },
        });
        drawFooter();
        if (index < Object.keys(avulsos).length - 1) doc.addPage();
      });
  //doc.output('datauri');
      doc.save(`pacote_${this.idPacote}.pdf`);
      
      this.$emit("fechar");
    
    },
    async carregarPdf(idPacote) {
      try {
        if(undefined !== idPacote){
          const response = await axios.get("/api/printpacote/"+ idPacote);
          this.dados = await response.data;
          this.makeToast("success", "Pacote Impresso com sucesso!")
        }
      } catch (err) {
        console.error("Erro ao carregar PDF do pacote:", err);
        this.makeToast("danger", "erro ao buscar informaçoes!: " + err)
      }
    },
     makeToast(variant = null, msg) {
        this.$bvToast.toast(msg, {
          title: `Exames`,
          variant: variant,
          solid: true
        })
      },
  }, mounted(){
    this.carregarPdf()
  }
};
</script>
