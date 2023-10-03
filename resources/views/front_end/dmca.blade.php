@extends('front_end.layout')
@section('content')
   <div style="clear:both;"></div>

    <!-- terms-condition start -->
    <section id="inner-main-content">
        <h2 class="heading">
            {{isset($page_meta['dmca_title']) && $page_meta['dmca_title']!='' ? $page_meta['dmca_title'] : 'DMCA'}}
        </h2>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-10 col-offset-md-1">
                    <div class="font-para">
                        @if(isset($page_meta['dmca_description']) && $page_meta['dmca_description']!='')
                            {!! $page_meta['dmca_description'] !!}
                        @else
                            <p>Nature checkout intends to fully comply with the Digital Millennium Copyright Act ("DMCA"), including the notice and "take down" provisions, and to benefit from the safe harbors immunizing Nature checkout from liability to the fullest extent of the law. Nature checkout reserves the right to terminate the account of any Member who infringes upon the copyright rights of others upon receipt of proper notification by the copyright owner or the copyright owner's legal agent.</p>
                            <p>Included below are the processes and procedures that Nature checkout will follow to resolve any claims of intellectual property violations:</p>
                        @endif
                        <div id="accordion">
                            @php $result = [];
                            if(isset($page_meta['dmca_content']) && $page_meta['dmca_content']!=''){
                                $result = json_decode($page_meta['dmca_content']);
                            }
                            @endphp
                            @if(!empty($result))
                                @php $i = 1; @endphp
                                @foreach($result as $row)
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="card-link" data-toggle="collapse" href="#collapse{{$i}}"><i class="fa fa-plus"></i>{{$row->title}}</a>
                                        </div>
                                        <div id="collapse{{$i}}" class="collapse @if($i==1) show @endif" data-parent="#accordion">
                                            <div class="card-body">
                                                {!! $row->description !!}
                                            </div>
                                        </div>
                                    </div>
                                    @php $i++; @endphp
                                @endforeach
                            @else
                                <div class="card">
                                    <div class="card-header">
                                        <a class="card-link" data-toggle="collapse" href="#collapse1"><i class="fa fa-plus"></i>Notice for Claims of Intellectual Property Violations</a>
                                    </div>
                                    <div id="collapse1" class="collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>If you believe that your work has been copied in a way that constitutes copyright infringement, or that your intellectual property rights have been otherwise violated, please provide Nature checkout's Copyright Agent with the following information:</p>
                                            <ul class="bullet">
                                                <li>An electronic or physical signature of the person authorized to act on behalf of the owner (the Complainant) of the copyright or other intellectual property interest that has allegedly been infringed</li>
                                                <li>A description of the copyrighted work or other intellectual property that the Complainant claims has been infringed</li>
                                                <li>A description of where the infringing material or activity that the Complainant is located on the Site, with enough detail that we may find it on the Site (e.g., Profile ID)</li>
                                                <li>The name, address, telephone number and email address of the Complainant</li>
                                                <li>A statement by the Complainant that upon a good faith belief the disputed use of the material or activity is not authorized by the copyright or intellectual property owner, its agent or the law; and</li>
                                                <li>A statement by the Complainant made under penalty of perjury, that the Complainant is the copyright or intellectual property owner or is authorized to act on behalf of the copyright or intellectual property owner and that the information provided in the notice is accurate.</li>
                                            </ul>
                                            <p>Nature checkout's Copyright Agent for Notice for Claims of Intellectual Property Violations can be reached as follows: E-Mail: info@naturecheckout.comand subject line: ABUSE</p>
                                            <p>Alternatively, we have a takedown API available to fast track the DMCA requests. Inquire at the email above if you're interested in using it.</p>
                                            <p>Upon Nature checkout's receipt of a Notice for Claims of Intellectual Property Violations, Nature checkout will take the following steps:</p>
                                            <ul class="bullet">
                                                <li>Promptly remove or disable access to the material or activity claiming to be infringing</li>
                                                <li>Notify the Member responsible for posting the alleged infringement of copyright or other intellectual property rights that the material or activity has been removed or access to it has been disabled; and</li>
                                                <li>Provide the Member with a Counter Notification Form outlining the steps they are required to follow if they wish to respond.</li>
                                                <li>Notify the Complainant once the access to the material has been removed or disabled.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapse2"><i class="fa fa-plus"></i>Counter Notification Form</a>
                                    </div>
                                    <div id="collapse2" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>If a Member receives notice that a material or activity posted on the Site was removed or disabled and the Member wishes to dispute the Notice for Claims of Intellectual Property Violations, the Member must provide Nature checkout's Copyright Agent with the following information:</p>
                                            <ul class="bullet">
                                                <li>An electronic or physical signature of the Member;</li>
                                                <li>A description of the copyrighted work or other intellectual property that has been removed or disabled and the location where the material appeared before removed or disabled;</li>
                                                <li>A statement by the Member, made under penalty of perjury, that the Member has a good faith belief that the material was removed or disabled as a result of mistake or misidentification; and</li>
                                                <li>The Member's name, address, telephone number and email address, and a statement that the Member consents to the jurisdiction of Los Angeles District Court for the judicial district in which the Member's residence is located if in the United States, or a similar court in the country of the Member's residence. The Member must also provide a statement that they will accept service of process from the Complainant.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapse3"><i class="fa fa-plus"></i>Nature checkout's Response upon Receipt of a Counter Notification Form.</a>
                                    </div>
                                    <div id="collapse3" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Upon Nature checkout's receipt of a Counter Notification Form, Nature checkout will take the following steps:</p>
                                            <ul class="bullet">
                                                <li>Promptly provide the Complainant with a copy of the Counter Notification Form;</li>
                                                <li>Promptly inform the Complainant that the removed or disabled material or activity will be replaced or re-enabled in not less than ten (10), but no more than fourteen (14), business days unless Nature checkout's Copyright Agent first receives notice that the Complainant has filed an action seeking a court order to restrain the Member from engaging in infringing activity relating to the material or activity on the Site; and</li>
                                                <li>After the period in Section (D)(2) above has elapsed, replace or re-enable the disabled material unless a notice of action as defined in Section (D)(2) above has been received (unless the material is determined by Nature checkout in its sole discretion to potentially infringe any intellectual property rights).</li>
                                            </ul>
                                            <p>To the extent the notices and "take down" requirements above deviate from the requirements under the DMCA, then the notice requirements as provided by the DMCA shall control and are herein incorporated by reference.In accordance with the DMCA, we have adopted a policy of terminating, in appropriate circumstances and in the sole discretion of Nature checkout, Members who are deemed to be repeat copyright infringers. We may also in our sole discretion limit access to the Site and/or terminate the account of any Member who infringes upon any intellectual property rights of others, whether or not there is any repeat infringement.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                  </div>
                </div>
            </div>
        </div>
    </section>
    <!--<script>
  $( function() {
    $( "#accordion" ).accordion({
      collapsible: true,
      heightStyle: "content",
      activate: function( event, ui ) {
      if(!$.isEmptyObject(ui.newHeader.offset())) {
        $('html:not(:animated), body:not(:animated)').animate({ scrollTop: ui.newHeader.offset().top }, 'slow');
      }
    }
    });
  } );
</script>-->
@endsection



