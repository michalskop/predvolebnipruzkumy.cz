{extends file='main.tpl'}
{block name=body}
<div class="container">
 <div class="bs-docs-section">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1 id="type">Widgety</h1>
            </div>
        </div>
    </div>

    <h4>Obecná adresa</h4>
      <code>http://predvolebnipruzkumy.cz/widget/[typ_grafu]/?<i>[parameters]</i></code>
    <h4>Line chart <small>(typ grafu)</small></h4>
      <code>http://predvolebnipruzkumy.cz/widget/linechart/?<i>[parameters]</i></code>
        <h5>Parametry</h5>
          <ul>
            <li><code>since</code> - počáteční datum ve formátu YYYY-mm-dd</li>
            <li><code>until</code> - konečné datum ve formátu YYYY-mm-dd</li>
            <li><code>topic_id</code> - téma průzkumu: <em>model-psp</em>, <em>ucast-psp</em>, <em>preference-psp</em>, atd. Vizte <a href="http://predvolebnipruzkumy.cz/api/v0.1/topics/">výstup z API</a></li>
            <li><code>pollster_id</code> - kdo průzkum dělal: <em>CVVM</em>, <em>Median</em>, atd. Vizte <a href="http://predvolebnipruzkumy.cz/api/v0.1/pollsters/">výstup z API</a></li>
            <li><code>choice_id</code> - vybrané možnosti odpovědí: <em>ČSSD</em>, <em>top-09</em>, atd. Vizte <a href="http://predvolebnipruzkumy.cz/api/v0.1/choices/">výstup z API</a></li>
            <li><code>width</code> - šířka widgetu (px) <em>default: 900</em></li>
            <li><code>height</code> - výška widgetu (px) <em>default: 350</em></li>
          </ul>
    <h4>Příklady</h4>
      <h5>Kompletní vývoj modelu CVVM</h5>
        <code><a href="http://predvolebnipruzkumy.cz/widget/linechart/?topic_id=model-psp&pollster_id=CVVM&width=700&height=350">http://predvolebnipruzkumy.cz/widget/linechart/?topic_id=model-psp&pollster_id=CVVM&width=700&height=350</a></code>
      <h5>Vývoj ochoty jít k volbám mezi roku 2005 a 2010 dle CVVM</h5>
        <code><a href="http://predvolebnipruzkumy.cz/widget/linechart/?topic_id=ucast-psp&pollster_id=CVVM&since=2005-01-01&until=2010-12-31&width=400&height=200">http://predvolebnipruzkumy.cz/widget/linechart/?topic_id=ucast-psp&pollster_id=CVVM&since=2005-01-01&until=2010-12-31&width=400&height=200</a></code>
      <h5>Srovnání 2 stran <small>(model CVVM)</small></h5>
        <code><a href="http://predvolebnipruzkumy.cz/widget/linechart/?topic_id=model-psp&pollster_id=CVVM&choice_id[]=ODS&choice_id[]=ČSSD&width=700&height=250">http://predvolebnipruzkumy.cz/widget/linechart/?topic_id=model-psp&pollster_id=CVVM&choice_id[]=ODS&choice_id[]=ČSSD&width=700&height=250</a></code>
      <p> </p>
  </div>
</div> 

{/block}
