<style>
.pos-form-actions {
    padding: 15px; 
    background: linear-gradient(135deg, #6200EA 10%, #BB86FC 90%); /* Gradien yang lebih halus */
    border-radius: 12px 12px 0 0;
    box-shadow: 0px 8px 16px rgba(0,0,0,0.12); /* Shadow yang lebih mencolok */
    border-top: 4px solid #BB86FC; /* Menggunakan warna yang lebih lembut */
      max-height: 80vh;  /* Maksimal 80% dari tinggi viewport */
    overflow-y: auto;
}

.pos-form-actions .btn {
    border-radius: 8px; 
    margin: 0 10px 10px 0;
    padding: 10px 20px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.08); /* Shadow yang lebih halus */
    transition: all 0.3s ease; /* Efek transisi yang berlaku untuk semua property */
}

.pos-form-actions .btn:hover {
    background-color: #BB86FC; /* Warna background saat di-hover */
    transform: translateY(-3px); 
    box-shadow: 0 6px 12px rgba(0,0,0,0.15); 
}

.pos-form-actions .btn:active {
    transform: translateY(1px);
    box-shadow: 0 3px 6px rgba(0,0,0,0.1); 
}

.pos-total {
    display: inline-flex; 
    justify-content: space-between;
 align-items: center;
 background: #BB86FC;
    padding: 12px 25px;
    width: 30%; /* Default untuk desktop */
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    margin: 10px 20px;
}


.pos-total .text, .pos-total .number {
    margin: 0;
    padding: 0;
    vertical-align: middle;
}

.pos-total .text {
    font-size: 1.2em; /* Ukuran lebih kecil untuk label */
    color: #ffffff;
    font-weight: 400; /* Weight yang sedikit lebih ringan */
}

.pos-total .number {
    font-size: 2.2em; /* Ukuran lebih besar untuk angka total */
    color: #ffffff; /* Mengganti warna angka total menjadi putih */
    font-weight: bold;
}

/* Efek hover khusus untuk button .pos-total */
.pos-total:hover {
    background-color: #6200EA;
}

@media (max-width: 768px) {
    .pos-form-actions .btn {
        width: 48%;
        margin-right: 2%; /* Menambahkan sedikit jarak antar tombol di mobile */
    }
     .pos-total {
        width: 60%; /* Anda bisa mengatur sesuai kebutuhan, misalnya 50% atau 70%, tergantung tampilan yang Anda inginkan */
        margin: 10px auto; /* Menggunakan 'auto' untuk margin kiri dan kanan agar elemen tetap berada di tengah */
    }
}
@media (max-width: 480px) {
    .pos-total {
        width: 100%; /* Menggunakan seluruh lebar tersedia pada perangkat mobile */
        margin: 10px 0; /* Menghilangkan margin kiri dan kanan untuk menggunakan lebar penuh */
    }
    .pos-total .text, .pos-total .number {
        margin: 0;
        padding: 0;
        line-height: 1.2;
}

</style>


@php
	$is_mobile = isMobile();
@endphp
<div class="row">
	<div class="pos-form-actions">
		<div class="col-md-12">
			@if($is_mobile)
				<div class="col-md-12 text-right pos-total">
					<b>@lang('sale.total_payable'):</b>
					<input type="hidden" name="final_total" 
												id="final_total_input" value=0>
					<span id="total_payable" class="text-success text-bold text-right">0</span>
				</div>
			@endif
			<button type="button" class="@if($is_mobile) col-xs-6 @endif btn bg-info text-white btn-default btn-flat @if($pos_settings['disable_draft'] != 0) hide @endif" id="pos-draft" @if(!empty($only_payment)) disabled @endif><i class="fas fa-edit"></i> @lang('sale.draft')</button>
			<button type="button" class="btn btn-default bg-yellow btn-flat @if($is_mobile) col-xs-6 @endif" id="pos-quotation" @if(!empty($only_payment)) disabled @endif><i class="fas fa-edit"></i> @lang('lang_v1.quotation')</button>

			@if(empty($pos_settings['disable_suspend']))
				<button type="button" 
				class="@if($is_mobile) col-xs-6 @endif btn bg-red btn-default btn-flat no-print pos-express-finalize" 
				data-pay_method="suspend"
				title="@lang('lang_v1.tooltip_suspend')" @if(!empty($only_payment)) disabled @endif>
				<i class="fas fa-pause" aria-hidden="true"></i>
				@lang('lang_v1.suspend')
				</button>
			@endif

			@if(empty($pos_settings['disable_credit_sale_button']))
				<input type="hidden" name="is_credit_sale" value="0" id="is_credit_sale">
				<button type="button" 
				class="btn bg-purple btn-default btn-flat no-print pos-express-finalize @if($is_mobile) col-xs-6 @endif" 
				data-pay_method="credit_sale"
				title="@lang('lang_v1.tooltip_credit_sale')" @if(!empty($only_payment)) disabled @endif>
					<i class="fas fa-check" aria-hidden="true"></i> @lang('lang_v1.credit_sale')
				</button>
			@endif
			<button type="button" 
				class="btn bg-maroon btn-default btn-flat no-print @if(!empty($pos_settings['disable_suspend'])) @endif pos-express-finalize @if(!array_key_exists('card', $payment_types)) hide @endif @if($is_mobile) col-xs-6 @endif" 
				data-pay_method="card"
				title="@lang('lang_v1.tooltip_express_checkout_card')" >
				<i class="fas fa-credit-card" aria-hidden="true"></i> @lang('lang_v1.express_checkout_card')
			</button>

			<button type="button" class="btn bg-navy btn-default @if(!$is_mobile) @endif btn-flat no-print @if($pos_settings['disable_pay_checkout'] != 0) hide @endif @if($is_mobile) col-xs-6 @endif" id="pos-finalize" title="@lang('lang_v1.tooltip_checkout_multi_pay')"><i class="fas fa-money-check-alt" aria-hidden="true"></i> @lang('lang_v1.checkout_multi_pay') </button>

			<button type="button" class="btn btn-success @if(!$is_mobile) @endif btn-flat no-print @if($pos_settings['disable_express_checkout'] != 0 || !array_key_exists('cash', $payment_types)) hide @endif pos-express-finalize @if($is_mobile) col-xs-6 @endif" data-pay_method="cash" title="@lang('tooltip.express_checkout')"> <i class="fas fa-money-bill-alt" aria-hidden="true"></i> @lang('lang_v1.express_checkout_cash')</button>

			@if(empty($edit))
				<button type="button" class="btn btn-danger btn-flat @if($is_mobile) col-xs-6 @else btn-xs @endif" id="pos-cancel"> <i class="fas fa-window-close"></i> @lang('sale.cancel')</button>
			@else
				<button type="button" class="btn btn-danger btn-flat hide @if($is_mobile) col-xs-6 @else btn-xs @endif" id="pos-delete" @if(!empty($only_payment)) disabled @endif> <i class="fas fa-trash-alt"></i> @lang('messages.delete')</button>
			@endif

			@if(!$is_mobile)
			<div class="bg-navy pos-total text-white">
			<span class="text">@lang('sale.total_payable')</span>
			<input type="hidden" name="final_total" 
										id="final_total_input" value=0>
			<span id="total_payable" class="number">0</span>
			</div>
			@endif

			@if(!isset($pos_settings['hide_recent_trans']) || $pos_settings['hide_recent_trans'] == 0)
			<button type="button" class="pull-right btn btn-primary btn-flat @if($is_mobile) col-xs-6 @endif" data-toggle="modal" data-target="#recent_transactions_modal" id="recent-transactions"> <i class="fas fa-clock"></i> @lang('lang_v1.recent_transactions')</button>
			@endif

			
			
		</div>
	</div>
</div>
@if(isset($transaction))
	@include('sale_pos.partials.edit_discount_modal', ['sales_discount' => $transaction->discount_amount, 'discount_type' => $transaction->discount_type, 'rp_redeemed' => $transaction->rp_redeemed, 'rp_redeemed_amount' => $transaction->rp_redeemed_amount, 'max_available' => !empty($redeem_details['points']) ? $redeem_details['points'] : 0])
@else
	@include('sale_pos.partials.edit_discount_modal', ['sales_discount' => $business_details->default_sales_discount, 'discount_type' => 'percentage', 'rp_redeemed' => 0, 'rp_redeemed_amount' => 0, 'max_available' => 0])
@endif

@if(isset($transaction))
	@include('sale_pos.partials.edit_order_tax_modal', ['selected_tax' => $transaction->tax_id])
@else
	@include('sale_pos.partials.edit_order_tax_modal', ['selected_tax' => $business_details->default_sales_tax])
@endif

@include('sale_pos.partials.edit_shipping_modal')