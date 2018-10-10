<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "experts".
 *
 * @property int $id
 * @property string $name
 * @property string $website
 * @property string $old_description
 * @property string $description
 * @property string $spreadsheet
 * @property string $count_ratings
 * @property string $grading_ratings
 * @property string $paid_ratings
 * @property string $address
 * @property string $email
 * @property string $subscribe
 * @property string $comments
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Experts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'experts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['old_description', 'description', 'address', 'comments'], 'string'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'website', 'spreadsheet', 'grading_ratings', 'paid_ratings', 'email', 'subscribe'], 'string', 'max' => 255],
            [['count_ratings'], 'string', 'max' => 50],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/experts', 'ID'),
            'name' => Yii::t('app/experts', 'Name'),
            'website' => Yii::t('app/experts', 'Website'),
            'old_description' => Yii::t('app/experts', 'Old Description'),
            'description' => Yii::t('app/experts', 'Description'),
            'spreadsheet' => Yii::t('app/experts', 'Spreadsheet'),
            'count_ratings' => Yii::t('app/experts', 'Count Ratings'),
            'grading_ratings' => Yii::t('app/experts', 'Grading Ratings'),
            'paid_ratings' => Yii::t('app/experts', 'Paid Ratings'),
            'address' => Yii::t('app/experts', 'Address'),
            'email' => Yii::t('app/experts', 'Email'),
            'subscribe' => Yii::t('app/experts', 'Subscribe'),
            'comments' => Yii::t('app/experts', 'Comments'),
            'status' => Yii::t('app/experts', 'Status'),
            'created_at' => Yii::t('app/experts', 'Created At'),
            'updated_at' => Yii::t('app/experts', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ExpertsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ExpertsQuery(get_called_class());
    }
}
