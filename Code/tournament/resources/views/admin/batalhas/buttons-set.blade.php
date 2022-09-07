<button class="btn btn-primary btn-block{{ $round->status == 'em_andamento' ? ' disabled' : '' }}" data-type="vitoria">Vitória (Round)</button>
<button class="btn btn-primary btn-block{{ $round->status == 'em_andamento' ? ' disabled' : '' }}" data-type="ippon">Ippon (Vence Round)</button>
<button class="btn btn-default btn-block{{ $round->status == 'em_andamento' ? ' disabled' : '' }}" data-type="waza_ari">Waza-Ari (+10)</button>
<button class="btn btn-default btn-block{{ $round->status == 'em_andamento' ? ' disabled' : '' }}" data-type="yuko">Yuko (+6)</button>
<button class="btn btn-default btn-block{{ $round->status == 'em_andamento' ? ' disabled' : '' }}" data-type="koka">Koka (+4)</button>
<button class="btn btn-default btn-block{{ $round->status == 'em_andamento' ? ' disabled' : '' }}" data-type="yusei_gashi">Yusei-Gashi (+2)</button>