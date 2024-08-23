<?php

namespace backend\controllers\items;

use backend\models\items\Categories;
use backend\models\references\Regions;
use backend\models\users\RoleMethods;
use Yii;
use backend\models\items\ItemsLimits;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use \yii\web\Response;
use yii\helpers\Html;
use backend\models\settings\Settings;

/**
 * ItemsLimitsController реализует действия CRUD для ItemsLimits модель.
 */
class ItemsLimitsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * shu controllerga ruxsatni tekshirirsh
     * @return mixed
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $bbs = RoleMethods::getAccess($roles, 'bbs', 'bbs');
        $limit = RoleMethods::getAccess($roles, 'bbs', 'items-limits-payed');

        if ($bbs && $limit) {
            if ($action->id != null) {
                throw new HttpException(405, 'У вас нет разрешения на доступ к этому действию.');
            }
        }

        if ($limit) {
            if ($action->id != null) {
                throw new HttpException(405, 'У вас нет разрешения на доступ к этому действию.');
            }
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * items limitni listi
     * @return string
     */
    public function actionIndex()
    {
        // NULL = new Expression('null');
        $items = ItemsLimits::find();
        list($itemsInput, $shopsInput) = $items->where(['free' => 1, 'cat_id' => 0, 'district_id' => 0])
            ->orderBy('shop')->all();

        list($items_price_set, $items_price_set_shop) = $items->where(
            ['cat_id' => 0, 'district_id' => 0, 'free' => 0, 'items' => 0, 'group_id' => 0]
        )->orderBy('shop')->all();

        $itemsPrice = unserialize($items_price_set->settings ?: 'a:0:{}');

        $shopsPrice = unserialize($items_price_set_shop->settings ?: 'a:0:{}');

        $itemsRegions = $items->where(['shop' => 0, 'group_id' => 0])->andWhere(['!=', 'district_id', 0])->all();
        $shopsRegions = $items->where(['shop' => 1, 'group_id' => 0])->andWhere(['!=', 'district_id', 0])->all();

        $itemsCat = ItemsLimits::getData(0);
        $shopsCat = ItemsLimits::getData(1);

        $catReg = $items->where(['!=', 'cat_id', 0])->andWhere(['is not', 'settings', null])->andWhere(
            ['is not', 'title', null]
        )->andWhere(['shop' => 0])->all();
        $catRegShops = $items->where(['!=', 'cat_id', 0])->andWhere(['!=', 'settings', null])->andWhere(
            ['is not', 'title', null]
        )->andWhere(['shop' => 1])->all();

        $settings = Settings::find()->where(['key' => 'period_items_count'])->one();

        return $this->render(
            'index',
            compact(
                'itemsInput',
                'itemsCat',
                'itemsPrice',
                'itemsRegions',
                'shopsInput',
                'shopsCat',
                'shopsRegions',
                'shopsPrice',
                'catReg',
                'catRegShops',
                'settings'
            )
        );
    }


    /**
     * @param $type
     * @return array
     */
    public function actionCreateCatReg($type)
    {
        $request = Yii::$app->request;
        $model = new ItemsLimits();
        $post = $request->post();
        $items_sum = unserialize(
            ItemsLimits::find()->where(
                ['cat_id' => 0, 'shop' => $type, 'free' => 0, 'items' => 0, 'group_id' => 0, 'district_id' => 0]
            )->one()->settings
        );
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->load($request->post()) && $model->validate()) {
                $model->shop = $type;
                $model->free = 0;
                $model->group_id = 0;
                $settings = ItemsLimits::setSettings($post, $items_sum);
                $max_min = array_column($settings, 'price');
                $serialize = [
                    'min' => min($max_min),
                    'max' => max($max_min),
                    'regs' => []
                ];
                $model->title = serialize($serialize);
                $model->settings = serialize($settings);
                $model->save();
                return [
                    'forceReload' => 'body',
                    'forceClose' => true
                ];
            } else {
                return [
                    'title' => "Добавление",
                    'content' => $this->renderAjax(
                        'cat-form',
                        [
                            'model' => $model,
                            'items_sum' => $items_sum
                        ]
                    ),
                    'footer' => Html::button(
                            'Закрыть',
                            ['class' => 'btn btn-inverse pull-left', 'data-dismiss' => "modal"]
                        ) .
                        Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            }
        }
    }


    /**
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionUpdateCatReg($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $post = $request->post();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->load($request->post()) && $model->validate()) {
                $settings = ItemsLimits::setSettings($post, unserialize($model->settings));
                $max_min = array_column($settings, 'price');
                $serialize = [
                    'min' => min($max_min),
                    'max' => max($max_min),
                    'regs' => unserialize($model->title)['regs']
                ];
                $model->title = serialize($serialize);
                $model->settings = serialize($settings);
                $model->save();
                return [
                    'forceReload' => 'body',
                    'forceClose' => true
                ];
            } else {
                $model->settings = unserialize($model->settings);
                return [
                    'title' => "Изменить",
                    'content' => $this->renderAjax(
                        'cat-form',
                        [
                            'model' => $model,
                        ]
                    ),
                    'footer' => Html::button(
                            'Закрыть',
                            ['class' => 'btn btn-inverse pull-left', 'data-dismiss' => "modal"]
                        ) .
                        Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            }
        }
    }


    /**
     * @param $type
     * @return array
     */
    public function actionAddItem($type)
    {
        $model = ItemsLimits::find()->where(
            ['cat_id' => 0, 'shop' => $type, 'free' => 0, 'items' => 0, 'group_id' => 0, 'district_id' => 0]
        )->one();
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->itemCheck = 'check';
            if ($model->load($request->post()) && $model->validate()) {
                $serialize = unserialize($model->settings);
                $i = count($serialize) + 1;
                $serialize[$i] = [
                    'id' => $i,
                    'items' => $model->count,
                    'price' => $model->price,
                    'checked' => $model->check,
                ];
                $model->settings = serialize($serialize);
                $model->save();
                $all = ItemsLimits::find()->where(['is not', 'settings', null])->andWhere(['shop' => $type])->all();
                foreach ($all as $a) {
                    $serialize = unserialize($a->settings);
                    $serialize[$i] = [
                        'id' => $i,
                        'items' => $model->count,
                        'price' => $model->price,
                        'checked' => $model->check,
                    ];
                    $a->settings = serialize($serialize);
                    $a->save();
                }
                return [
                    'forceReload' => 'body',
                    'forceClose' => true
                ];
            } else {
                return [
                    'title' => "Добавление",
                    'content' => $this->renderAjax('items_form', compact('model')),
                    'footer' => Html::button(
                            'Закрыть',
                            ['class' => 'btn btn-inverse pull-left', 'data-dismiss' => "modal"]
                        ) .
                        Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        }
    }


    /**
     * @return string
     */
    public function actionCatReg()
    {
        $id = Yii::$app->request->post('id');
        $model = ItemsLimits::find()->where(['id' => $id])->asArray()->one();
        return $this->renderAjax('limitregion', ['model' => $model]);
    }


    /**
     * @return string
     */
    public function actionCategory()
    {
        $id = Yii::$app->request->post('type');
        $model = ItemsLimits::find()->where(['is not', 'cat_id', 0])->andWhere(
            ['is not', 'settings', new Expression('null')]
        )->andWhere(['is not', 'title', new Expression('null')])->andWhere(
            ['shop' => $id]
        )->all();
        return $this->renderAjax('_category', ['model' => $model, 'type' => $id]);
    }


    /**
     * @param $id
     * @param $type
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionRegCatCreate($id, $type)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $post = $request->post();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->load($request->post()) && $model->validate()) {
                ItemsLimits::deleteAll(['group_id' => $id]);
                $settings = ItemsLimits::setSettings($post, unserialize($model->settings));
                $max_min = array_column($settings, 'price');
                $settings = serialize($settings);
                $regs = [];
                foreach ($model->regions as $value) {
                    $dist = Regions::findOne(['id' => $value]);
                    $regs[$value] = ['lvl' => 3, 't' => $dist->name, 'c' => '9061'];
                    $new_model = new ItemsLimits();
                    $new_model->district_id = $dist->id;
                    $new_model->group_id = $id;
                    $new_model->shop = $type;
                    $new_model->items = 0;
                    $new_model->free = 0;
                    $new_model->enabled = 0;
                    $new_model->settings = $settings;
                    $new_model->save(false);
                }
                $title = ['min' => min($max_min), 'max' => max($max_min), 'regs' => $regs];
                $model->settings = $settings;
                $model->title = serialize($title);
                $model->save();
                return [
                    'forceReload' => 'body',
                    'forceClose' => true
                ];
            } else {
                $model->settings = unserialize($model->settings);
                $model->regions = array_keys(unserialize($model->title)['regs']);
                return [
                    'title' => "Добавление",
                    'content' => $this->renderAjax('region_from', compact('model')),
                    'footer' => Html::button(
                            'Закрыть',
                            ['class' => 'btn btn-inverse pull-left', 'data-dismiss' => "modal"]
                        ) .
                        Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        }
    }


    /**
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionRegionEdit($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $post = $request->post();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->load($request->post())) {
                $settings = ItemsLimits::setSettings($post, unserialize($model->settings));
                $max_min = array_column($settings, 'price');
                $settings = serialize($settings);
                ItemsLimits::deleteAll(['group_id' => $id]);
                $regs = [];
                foreach ($model->regions as $value) {
                    $dist = Regions::findOne($value);
                    if ($model->district_id != $value) {
                        $new_model = new ItemsLimits();
                        $new_model->district_id = $dist->id;
                        $new_model->group_id = $id;
                        $new_model->shop = $model->shop;
                        $new_model->items = 0;
                        $new_model->free = 0;
                        $new_model->enabled = 0;
                        $new_model->settings = $settings;
                        $new_model->save(false);
                    }
                    $regs[$value] = [
                        'lvl' => 3,
                        't' => $dist->name,
                        'c' => '9061'
                    ];
                }
                $title = [
                    'min' => min($max_min),
                    'max' => max($max_min),
                    'regs' => $regs
                ];
                $model->settings = $settings;
                $model->title = serialize($title);
                $model->save(false);
                return [
                    'forceReload' => 'body',
                    'forceClose' => true
                ];
            } else {
                $model->regions = array_keys(unserialize($model->title)['regs']);
                $model->settings = unserialize($model->settings);
                return [
                    'title' => "Добавление",
                    'content' => $this->renderAjax('region_from', compact('model')),
                    'footer' => Html::button(
                            'Закрыть',
                            ['class' => 'btn btn-inverse pull-left', 'data-dismiss' => "modal"]
                        ) .
                        Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        }
    }


    /**
     * @param $id
     * @return array
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRegionDel($id)
    {
        if (Yii::$app->request->isAjax) {
            ItemsLimits::deleteAll(['group_id' => $id]);
            ItemsLimits::findOne($id)->delete();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => 'body'];
        }
    }


    /**
     * @return false|string
     */
    public function actionSelect()
    {
        $id = Yii::$app->request->post('id');
        $categories = Categories::find()->where(['parent_id' => $id])->all();
        $result = '<option disabled selected>Выберите</option>';
        if ($categories) {
            foreach ($categories as $categorie) {
                $result .= "<option value = '" . $categorie->id . "'>" . $categorie->title . "</option>";
            }
            return $result;
        } else {
            return false;
        }
    }


    public function actionSetEnabledRegions()
    {
        $post = Yii::$app->request->post();
        /*$models = ItemsLimits::findAll(['group_id' => $post['id']]);
        foreach ($models as $model){
            $model->enabled == 0 ? $model->enabled = 1: $model->enabled = 0;
            $model->save();
        }*/
        $model = ItemsLimits::findOne($post['id']);
        $model->enabled == 0 ? $model->enabled = 1 : $model->enabled = 0;
        $model->save(false);
    }


    /**
     * @throws NotFoundHttpException
     */
    public function actionSetValue()
    {
        $post = Yii::$app->request->post();
        if ($post['type'] === 'items') {
            $model = $this->findModel($post['id']);
            $model->items = $post['value'];
            $model->save();
        } elseif ($post['type'] == 'price_check') {
            $itemsPrice = ItemsLimits::find()->where(
                ['cat_id' => 0, 'shop' => 0, 'free' => 0, 'items' => 0, 'group_id' => 0, 'district_id' => 0]
            )->one();
            $settings = unserialize($itemsPrice->settings);
            $se_new = [];
            foreach ($settings as $setting) {
                if ($setting['id'] == $post['id']) {
                    $se_new[] = [
                        'id' => $post['id'],
                        'items' => $setting['items'],
                        'price' => $setting['price'],
                        'checked' => $setting['checked'] == 1 ? 0 : 1
                    ];
                } else {
                    $se_new[] = [
                        'id' => $setting['id'],
                        'items' => $setting['items'],
                        'price' => $setting['price'],
                        'checked' => $setting['checked']
                    ];
                }
            }
            $itemsPrice->settings = serialize($se_new);
            $itemsPrice->save(false);
        } elseif ($post['type'] == 'price_val') {
            $itemsPrice = ItemsLimits::find()->where(
                ['cat_id' => 0, 'district_id' => 0, 'free' => 0, 'items' => 0, 'group_id' => 0, 'shop' => 0])->one();
            $settings = unserialize($itemsPrice->settings);
            $se_new = [];
            foreach ($settings as $setting) {
                if ($setting['id'] == $post['id']) {
                    $se_new[] = [
                        'id' => $post['id'],
                        'items' => $setting['items'],
                        'price' => $post['value'],
                        'checked' => $setting['checked']
                    ];
                } else {
                    $se_new[] = [
                        'id' => $setting['id'],
                        'items' => $setting['items'],
                        'price' => $setting['price'],
                        'checked' => $setting['checked']
                    ];
                }
            }
            $itemsPrice->settings = serialize($se_new);
            $itemsPrice->save(false);
        } elseif ($post['type'] == 'price_check_shop') {
            $itemsPrice = ItemsLimits::find()->where(
                ['cat_id' => 0, 'district_id' => 0, 'free' => 0, 'items' => 0, 'group_id' => 0, 'shop' => 1]
            )->one();
            $settings = unserialize($itemsPrice->settings);
            $se_new = [];
            foreach ($settings as $setting) {
                if ($setting['id'] == $post['id']) {
                    $se_new[] = [
                        'id' => $post['id'],
                        'items' => $setting['items'],
                        'price' => $setting['price'],
                        'checked' => $setting['checked'] == 1 ? 0 : 1
                    ];
                } else {
                    $se_new[] = [
                        'id' => $setting['id'],
                        'items' => $setting['items'],
                        'price' => $setting['price'],
                        'checked' => $setting['checked']
                    ];
                }
            }
            $itemsPrice->settings = serialize($se_new);
            $itemsPrice->save(false);
        } elseif ($post['type'] == 'price_val_shop') {
            $itemsPrice = ItemsLimits::find()->where(
                ['cat_id' => 0, 'shop' => 1, 'free' => 0, 'items' => 0, 'group_id' => 0, 'district_id' => 0]
            )->one();
            $settings = unserialize($itemsPrice->settings);
            $se_new = [];
            foreach ($settings as $setting) {
                if ($setting['id'] == $post['id']) {
                    $se_new[] = [
                        'id' => $post['id'],
                        'items' => $setting['items'],
                        'price' => $post['value'],
                        'checked' => $setting['checked']
                    ];
                } else {
                    $se_new[] = [
                        'id' => $setting['id'],
                        'items' => $setting['items'],
                        'price' => $setting['price'],
                        'checked' => $setting['checked']
                    ];
                }
            }
            $itemsPrice->settings = serialize($se_new);
            $itemsPrice->save(false);
        }
    }


    /**
     * @param $type
     * @return array
     */
    public function actionRegionCreate($type)
    {
        $request = Yii::$app->request;
        $model = new ItemsLimits();
        $post = $request->post();
        $items_sum = unserialize(
            ItemsLimits::find()->where(
                ['cat_id' => 0, 'shop' => $type, 'free' => 0, 'items' => 0, 'group_id' => 0, 'district_id' => 0]
            )->one()->settings
        );
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->load($request->post()) && $model->validate()) {
                $model->shop = $type;
                $settings = ItemsLimits::setSettings($post, $items_sum);
                $max_min = array_column($settings, 'price');
                $regs = [];
                $model->district_id = $model->regions[0];
                foreach ($model->regions as $value) {
                    $dist = Regions::findOne($value);
                    $regs[$value] = [
                        'lvl' => 3,
                        't' => $dist->name,
                        'c' => '9061'
                    ];
                }
                $title = [
                    'min' => min($max_min),
                    'max' => max($max_min),
                    'regs' => $regs
                ];
                $model->settings = serialize($settings);
                $model->title = serialize($title);
                $model->save();
                foreach ($model->regions as $value) {
                    $dist = Regions::findOne($value);
                    if ($dist->last_id != $model->regions[0]) {
                        $new_model = new ItemsLimits();
                        $new_model->district_id = $dist->id;
                        $new_model->group_id = $model->id;
                        $new_model->shop = $type;
                        $new_model->enabled = $model->enabled;
                        $new_model->settings = $model->settings;
                        $new_model->save();
                    }
                }
                return [
                    'forceReload' => 'body',
                    'forceClose' => true
                ];
            } else {
                return [
                    'title' => "Добавление",
                    'content' => $this->renderAjax('region_from', compact('model', 'items_sum')),
                    'footer' => Html::button(
                            'Закрыть',
                            ['class' => 'btn btn-inverse pull-left', 'data-dismiss' => "modal"]
                        ) .
                        Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        }
    }

    /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Создает новый ItemsLimits model.
     * Для ajax-запроса будет возвращен объект json, а для не-ajax-запроса,
     * если создание будет успешным, браузер будет перенаправлен на страницу просмотра.
     * @return mixed
     */
    public function actionCreate($type)
    {
        $request = Yii::$app->request;
        $model = new ItemsLimits();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->load($request->post()) && $model->validate()) {
                $model->shop = $type;
                $model->free = 1;
                $model->enabled = 0;
                $model->group_id = 0;
                $serialize = [
                    'cat' => [
                        $model->cat_id => [
                            'id' => $model->cat_id,
                            'title' => $model->category->title
                        ]
                    ]
                ];
                $model->title = serialize($serialize);
                if ($model->save()) {
                    return [
                        'forceReload' => $type == 0 ? '#crud-datatable-pjax' : '#datatable-shops-pjax',
                        'forceClose' => true
                    ];
                }
            } else {
                return [
                    'title' => "Добавление",
                    'content' => $this->renderAjax(
                        'create',
                        [
                            'model' => $model,
                        ]
                    ),
                    'footer' => Html::button(
                            'Закрыть',
                            ['class' => 'btn btn-inverse pull-left', 'data-dismiss' => "modal"]
                        ) .
                        Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        }
    }

    /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Обновляет существующий ItemsLimits модель.
     * Для запроса ajax вернет объект json и для запроса не-ajax, если обновление выполнено успешно, браузер будет
     * перенаправлен на страницу просмотра.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->load($request->post()) && $model->validate()) {
                $serialize = [
                    'cat' => [
                        $model->cat_id => [
                            'id' => $model->cat_id,
                            'title' => $model->category->title
                        ]
                    ]
                ];
                $model->title = serialize($serialize);
                $model->save();
                return [
                    'forceReload' => $model->shop == 0 ? '#crud-datatable-pjax' : '#datatable-shops-pjax',
                    'forceClose' => true
                ];
            } else {
                return [
                    'title' => "Изменить",
                    'content' => $this->renderAjax(
                        'update',
                        [
                            'model' => $model
                        ]
                    ),
                    'footer' => Html::button(
                            'Закрыть',
                            ['class' => 'btn btn-inverse pull-left', 'data-dismiss' => "modal"]
                        ) .
                        Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        }
    }


    /**
     *
     */
    public static function actionSetEnabled()
    {
        $post = Yii::$app->request->post();
        $model = ItemsLimits::findOne($post['id']);
        $model->enabled == 1 ? $model->enabled = 0 : $model->enabled = 1;
        $model->save();
    }

    /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Удалить существующий ItemsLimits модель.
     * Для запроса ajax вернет объект json и для запроса не-ajax, если удаление прошло успешно, браузер будет
     * перенаправлен на страницу «index».
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if ($request->isAjax) {
            /*
            *   Процесс для ajax-запроса
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Процесс для не-AJAX-запроса
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Удалить несколько существующих ItemsLimits модель.
     * Для запроса ajax вернет объект json и для запроса не-ajax, если удаление прошло успешно, браузер будет
     * перенаправлен на страницу «index».
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks'));
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            /*
            *   Процесс для ajax-запроса
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Процесс для не-AJAX-запроса
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Находит модель ItemsLimits На основе значения ее первичного ключа.
     * Если модель не найдена, будет выдано исключение 404 HTTP.
     * @param integer $id
     * @return ItemsLimits загруженная модель
     * @throws NotFoundHttpException если модель не может быть найдена
     */
    protected function findModel($id)
    {
        if (($model = ItemsLimits::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }

    public function actionChangeSettings()
    {
        $request = Yii::$app->request;
        $post = $request->post();
        $settings = Settings::find()->where(['key' => 'period_items_count'])->one();
        if ($post != null) {
            $settings->value = (string)$post['Settings']['value'];
        }
        $settings->save();
        return $this->redirect('index');
    }


    /**
     * @param int $id
     * @param int $type
     * @return array
     */
    public function actionUpdatePriceLimit(int $id, int $type = 0)
    {
        $request = Yii::$app->request;
        $model = new ItemsLimits();
        $post = $request->post();
        if ($request->isAjax) {
            $itemsPrice = ItemsLimits::find()->where(
                ['cat_id' => 0, 'shop' => $type, 'free' => 0, 'items' => 0, 'group_id' => 0, 'district_id' => 0]
            )->one();
            $settings = unserialize($itemsPrice->settings);
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($post) {
                $se_new = [];
                foreach ($settings as $setting) {
                    if ($setting['id'] == $id) {
                        $se_new[] = [
                            'id' => $id,
                            'items' => $post['items'],
                            'price' => $post['price'],
                            'checked' => isset($post['checked']) ? 1:0
                        ];
                    } else {
                        $se_new[] = [
                            'id' => $setting['id'],
                            'items' => $setting['items'],
                            'price' => $setting['price'],
                            'checked' => $setting['checked']
                        ];
                    }
                }
                $itemsPrice->settings = serialize($se_new);
                $itemsPrice->save(false);

                return [
                    'forceReload' => 'body',
                    'forceClose' => true
                ];
            } else {
                $item = reset($settings);
                foreach ($settings as $setting) {
                    if ($setting['id'] == $id){
                        $item = $setting;
                    }
                }
                return [
                    'title' => "Добавление",
                    'content' => $this->renderAjax('_form_price', ['item' => $item]),
                    'footer' => Html::button(
                            'Закрыть',
                            ['class' => 'btn btn-inverse pull-left', 'data-dismiss' => "modal"]
                        ) .
                        Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            }
        }
    }
}
