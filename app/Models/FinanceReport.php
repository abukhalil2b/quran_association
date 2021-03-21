<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceReport extends Model {
	public function userFinanceReportPermission() {
		return $this->belongsToMany(User::class, 'user_finance_report_permission', 'finance_report_id', 'user_id');
	}
	protected $fillable = ['date', 'title', 'inbank', 'totalExpenses', 'totalRevenues', 'balance', 'tax', 'note', 'file'];

}
