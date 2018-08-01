<p>Feedback</p>

<table cellspacing="0" style="width:100%">
	<tbody>
		<tr>
			<td style="height:50px"><img alt="logo" src="{{url('public/media/front/img/logo.png')}}" style="width:150px" /></td>
			<td style="height:50px">
			<h3>&nbsp;</h3>
			</td>
		</tr>
	</tbody>
</table>

<table cellpadding="0" cellspacing="0" style="width:100%">
	<tbody>
		<tr>
			<td>
			<h3>User Feedback</h3>

			<p><strong>Hello Admin,</strong><br />
			Here is feedback given by your customer {{$FIRST_NAME.&#39; &#39;.$LAST_NAME}} to Counselor {{ $EXPERT_FIRST_NAME.&#39; &#39;.$EXPERT_LAST_NAME }}.</p>
			{!! $FEEDBACK !!}</td>
		</tr>
	</tbody>
</table>

<p>Kind regards,</p>

<p>The Paras Fashions Team.</p>

<p>{{$SITE_TITLE}}</p>
