<?php

namespace App\Http\Controllers;

use App\Forms;
use App\Store;
use App\Business;
use App\StoreItems;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index() {

    }

    public function setup() {
        // if store already setup, redirect to settings
        if(auth()->user()->hasStore()) {
            return redirect('/store/settings')->with('success', 'Store setup done, you can modify settings.');
        }

        return view('store.setup');
    }

    public function setupPost(Request $request) {
        $request->validate([
            'store_url_slug'        => ['required', 'unique:stores'],
            'store_title'           => ['required'],
            'store_header_color'    => ['required'],
            'store_font_color'      => ['required'],
            'store_footer_color'    => ['required']
        ]);

        $store_logo_file = $request->file('store_logo');
        $store_logo = '';
        $dir = public_path('uploads/store/logo');

        if($store_logo_file) {
            $store_logo = md5($store_logo_file->getClientOriginalName()) . '.' . $store_logo_file->getClientOriginalExtension();
            $store_logo_file->move($dir, $store_logo);
        } else {
            $store_logo = NULL;
        }

        $store = new Store();
        $store->user_id = auth()->id();
        $store->store_url_slug = $request->store_url_slug;
        $store->store_title = $request->store_title;
        $store->store_header_color = $request->store_header_color;
        $store->store_font_color = $request->store_font_color;
        $store->store_footer_color = $request->store_footer_color;
        $store->store_logo = $store_logo;
        $store->save();

        return redirect('/store/settings')->with('success', 'Store setup completed.');
    }

    /**
     * Store Settings
     *
     * @return void
     */
    public function settings() {
        $store = auth()->user()->store();
        return view('store.settings', ['store' => $store]);
    }
    /**
     * Store Settings POST
     *
     * @param Request $request
     * @return void
     */
    public function settingsPost(Request $request) {
        $request->validate([
            // 'store_url_lug'        => ['required', 'unique:stores'],
            'store_title'           => ['required'],
            'store_header_color'    => ['required'],
            'store_font_color'      => ['required'],
            'store_footer_color'    => ['required'],
            'store_logo'            => ['nullable'],
            'store_banner_image'    => ['nullable'],
            'store_banner_text'     => ['nullable']
        ]);

        $store_banner_image_file = $request->file('store_banner_image');
        $store_banner_image = '';
        $dir = public_path('uploads/store/logo');

        $store = auth()->user()->store();

        if($store_banner_image_file) {
            $store_banner_image = md5($store_banner_image_file->getClientOriginalName()) . '.' . $store_banner_image_file->getClientOriginalExtension();
            $store_banner_image_file->move($dir, $store_banner_image);
        } else {
            $store_banner_image = $store->store_banner_image;
        }


        $store_logo_file = $request->file('store_logo');
        $store_logo = '';
        $dir = public_path('uploads/store/logo');

        if($store_logo_file) {
            $store_logo = md5($store_logo_file->getClientOriginalName()) . '.' . $store_logo_file->getClientOriginalExtension();
            $store_logo_file->move($dir, $store_logo);
        } else {
            $store_logo = $store->store_logo;
        }


        $store = Store::find(auth()->user()->store()->id);
        // $store->store_url_slug = $request->store_url_slug;
        $store->store_title = $request->store_title;
        $store->store_header_color = $request->store_header_color;
        $store->store_font_color = $request->store_font_color;
        $store->store_footer_color = $request->store_footer_color;
        $store->store_logo = $store_logo;
        $store->store_banner_image = $store_banner_image;
        $store->store_banner_text = $request->store_banner_text;
        $store->save();

        return redirect('/store/settings')->with('success', 'Store updated.');
    }

    /**
     * View Store
     */
    public function view(Request $request, $slug) {
        $store = Store::where('store_url_slug', $slug)->firstOrFail();
        $business = Business::where('user_id', $store->user_id)->first();

        $items = [];

        if (!$request->get('query')):
            $items = StoreItems::where('store_id', $store->id)->where('hidden', FALSE)->paginate(10);
        else:
            $items = StoreItems::where('store_id', $store->id)->where('hidden', FALSE)->where('item_name', 'LIKE', '%'.$request->get('query').'%')->paginate(10);
        endif;

        return view('store.view', ['store' => $store, 'business' => $business, 'items' => $items]);
    }

    /**
     * Manage Store Items
     */
    public function items() {
        $store = auth()->user()->store();
        $store_items = StoreItems::orderBy('created_at', 'DESC')->where('store_id', $store->id)->get();
        return view('store.items', ['items' => $store_items]);
    }

    /**
     * Create Item
     */
    public function itemsAdd() {
        $forms = Forms::where('business_id', auth()->id())->get();

        return view('store.add_item', ['forms' => $forms]);
    }

    /**
     * Create Item Post
     */
    public function itemsPost(Request $request) {
        $request->validate([
            'item_name'         => ['required'],
            'item_description'  => ['required'],
            'item_amount'       => ['required', 'numeric'],
            'item_featured_image'      => ['required', 'mimes:jpg,jpeg,png'],
        ]);

        $item_featured_image_file = $request->file('item_featured_image');
        $item_image_1_file = $request->file('item_image_1');
        $item_image_2_file = $request->file('item_image_2');
        $item_image_3_file = $request->file('item_image_3');
        $item_image_4_file = $request->file('item_image_4');

        $dir = public_path('uploads/store/items');

        if($item_featured_image_file) {
            $item_featured_image = md5($item_featured_image_file->getClientOriginalName()) . '.' . $item_featured_image_file->getClientOriginalExtension();
            $item_featured_image_file->move($dir, $item_featured_image);
        } else {
            $item_featured_image = NULL;
        }

        if($item_image_1_file) {
            $item_image_1 = md5($item_image_1_file->getClientOriginalName()) . '.' . $item_image_1_file->getClientOriginalExtension();
            $item_image_1_file->move($dir, $item_image_1);
        } else {
            $item_image_1 = NULL;
        }

        if($item_image_2_file) {
            $item_image_2 = md5($item_image_2_file->getClientOriginalName()) . '.' . $item_image_2_file->getClientOriginalExtension();
            $item_image_2_file->move($dir, $item_image_2);
        } else {
            $item_image_2 = NULL;
        }

        if($item_image_3_file) {
            $item_image_3 = md5($item_image_3_file->getClientOriginalName()) . '.' . $item_image_3_file->getClientOriginalExtension();
            $item_image_3_file->move($dir, $item_image_3);
        } else {
            $item_image_3 = NULL;
        }

        if($item_image_4_file) {
            $item_image_4 = md5($item_image_4_file->getClientOriginalName()) . '.' . $item_image_4_file->getClientOriginalExtension();
            $item_image_4_file->move($dir, $item_image_4);
        } else {
            $item_image_4 = NULL;
        }

        $store_item                   = new StoreItems();
        $store_item->store_id         = auth()->user()->store()->id;
        $store_item->item_name        = $request->item_name;
        $store_item->item_headline        = 'nothnig';
        $store_item->item_sub_headline        = 'nothing';
        $store_item->item_description = $request->item_description;
        $store_item->item_amount      = $request->item_amount;
        $store_item->item_featured_image     = $item_featured_image;
        $store_item->item_image_1     = $item_image_1;
        $store_item->item_image_2     = $item_image_2;
        $store_item->item_image_3     = $item_image_3;
        $store_item->item_image_4     = $item_image_4;
        $store_item->form_id          = $request->form_id;
        $store_item->save();

        return redirect('/store/items')->with('success', 'Store item added.');
    }
    /**
     * Edit Item
     */
    public function itemsEdit($id) {
        $item = StoreItems::find($id);
        $forms = Forms::where('business_id', auth()->id())->get();

        return view('store.edit_item', ['item' => $item, 'forms' => $forms]);
    }
    /**
     * Edit Item Post
     */
    public function itemsEditPost(Request $request, $id) {
        $request->validate([
            'item_name'         => ['required'],
            'item_description'  => ['required'],
            'item_amount'       => ['required'],
            'item_featured_image'      => ['nullable', 'mimes:jpg,jpeg,png'],
        ]);

        $item = StoreItems::find($id);

        $item_featured_image_file = $request->file('item_featured_image');
        $item_image_1_file = $request->file('item_image_1');
        $item_image_2_file = $request->file('item_image_2');
        $item_image_3_file = $request->file('item_image_3');
        $item_image_4_file = $request->file('item_image_4');

        $dir = public_path('uploads/store/items');

        if($item_featured_image_file) {
            $item_featured_image = md5($item_featured_image_file->getClientOriginalName()) . '.' . $item_featured_image_file->getClientOriginalExtension();
            $item_image_1_file->move($dir, $item_featured_image);
        } else {
            $item_featured_image = $item->item_featured_image;
        }

        if($item_image_1_file) {
            $item_image_1 = md5($item_image_1_file->getClientOriginalName()) . '.' . $item_image_1_file->getClientOriginalExtension();
            $item_image_1_file->move($dir, $item_image_1);
        } else {
            $item_image_1 = $item->item_image_1;
        }

        if($item_image_2_file) {
            $item_image_2 = md5($item_image_2_file->getClientOriginalName()) . '.' . $item_image_2_file->getClientOriginalExtension();
            $item_image_2_file->move($dir, $item_image_2);
        } else {
            $item_image_2 = $item->item_image_2;
        }

        if($item_image_3_file) {
            $item_image_3 = md5($item_image_3_file->getClientOriginalName()) . '.' . $item_image_3_file->getClientOriginalExtension();
            $item_image_3_file->move($dir, $item_image_3);
        } else {
            $item_image_3 = $item->item_image_3;
        }

        if($item_image_4_file) {
            $item_image_4 = md5($item_image_4_file->getClientOriginalName()) . '.' . $item_image_4_file->getClientOriginalExtension();
            $item_image_4_file->move($dir, $item_image_4);
        } else {
            $item_image_4 = $item->item_image_3;
        }

        $store_item                   = StoreItems::find($id);
        $store_item->item_name        = $request->item_name;
        $store_item->item_headline        = 'nothnig';
        $store_item->item_sub_headline        = 'nothing';
        $store_item->item_description = $request->item_description;
        $store_item->item_featured_image     = $item_featured_image;
        $store_item->item_amount      = $request->item_amount;
        $store_item->item_image_1     = $item_image_1;
        $store_item->item_image_2     = $item_image_2;
        $store_item->item_image_3     = $item_image_3;
        $store_item->item_image_4     = $item_image_4;
        $store_item->form_id          = $request->form_id;
        $store_item->save();

        return redirect('/store/items')->with('success', 'Store item modified.');
    }

    /**
     * Hide Item
     */
    public function hideItem($id) {
        $store_item = StoreItems::find($id);
        $store_item->hidden = true;
        $store_item->save();

        return back()->with('success', 'Item hidden');
    }
    /**
     * Un Hide Item
     */
    public function unhideItem($id) {
        $store_item = StoreItems::find($id);
        $store_item->hidden = false;
        $store_item->save();

        return back()->with('success', 'Item un-hidden');
    }
    /**
     * Delete Item
     */
    public function itemsDelete($id) {
        $store_item = StoreItems::find($id);
        $store_item->delete();

        return back()->with('success', 'Item deleted.');
    }

    /**
     * View Item
     */
    public function viewItem($slug, $item_id, $item_slug) {
        $store = Store::where('store_url_slug', $slug)->firstOrFail();
        $business = Business::where('user_id', $store->user_id)->first();
        $item = StoreItems::find($item_id);
        $form = Forms::find($item->form_id);

        return view('store.view_item', ['store' => $store, 'business' => $business, 'item' => $item, 'form' => $form]);
    }
    /**
     * Duplicate Item
     */
    public function duplicateItem($id) {
        $item = StoreItems::find($id);

        $new_item = $item->replicate();
        $new_item->store_id = $item->store_id;
        $new_item->save();

        return back()->with('success', 'Item Duplicated.');
    }
}
