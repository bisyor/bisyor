<?php

namespace App\Http\Controllers\References;

use App;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\References\Redirects;
use App\Models\Items\Categories;

use App\Models\Blogs\BlogPosts;
use App\Models\References\Seo;
use App\Models\References\Caching;
use App\Models\Shops\Shops;
use App\Models\Items\Items;

class TrashController extends Controller
{
	public function clearItem(Request $request)
	{
		Caching::clearItemViewCache($request->keyword);
		//return Caching::getItemViewCache($request->keyword);
	}

	/*public function redirect(Request $request)
	{
		$currentCategory = Categories::where(['keyword' => $request->keyword, 'enabled' => 1])->with(['translates', 'children', 'parent'])->first();

		if($currentCategory != null) {
			$keywords = $currentCategory->getChildrenKeyword($currentCategory->id);
			array_push($keywords, $currentCategory->keyword);

			foreach ($keywords as $keyword) {
				$from_uri = '/obyavlenie/' . $keyword;
				$to_uri = '/obyavlenie/list/' . $keyword;
				$model = Redirects::where(['from_uri' => $from_uri])->first();
				if($model == null) {
					$model = new Redirects();
					$model->from_uri = $from_uri;
					$model->to_uri = $to_uri;
					$model->status = 301;
					$model->is_relative = true;
					$model->add_extra = true;
					$model->add_query = true;
					$model->enabled = true;
					$model->date_cr = date('Y-m-d H:i:s');
					$model->date_up = date('Y-m-d H:i:s');
					$model->user_id = 1;
					$model->user_ip = request()->ip();
					$model->joined = 1;
					$model->joined_module = 'bbs-cats';
					$model->save();
				}
			}
			//dd($currentCategory->getChildrenKeyword($currentCategory->id));

		}
	}*/
}