<?php
/*
 * @version .9
 * @link https://raw.github.com/Opine-Org/Semantic-CM/master/available/blogs.php
 * @mode upgrade
 *
 * .6 add categories to list
 * .7 typo
 * .8 make description use count variable
 * .9 definition added
 */
namespace Sample\Manager;

class Blogs
{
    public $collection = 'blogs';
    public $title = 'Blogs';
    public $titleField = 'title';
    public $singular = 'Blog';
    public $description = '{{count}} blogs';
    public $definition = 'Regularly updated content can be added through blog posts. Entries are displayed in a list view where the most recent appears first. ';
    public $acl = ['content', 'admin', 'superadmin'];
    public $tabs = ['Main', 'Images', 'External Article', 'SEO'];
    public $icon = 'text file';
    public $category = 'Content';
    public $after = 'function';
    public $function = 'ManagerSaved';
    public $storage = [
        'collection' => 'blogs',
        'key' => '_id',
    ];

    public function titleField()
    {
        return [
            'name'        => 'title',
            'label'        => 'Title',
            'required'    => true,
            'display'    => 'InputText'
        ];
    }

    public function bodyField()
    {
        return [
            'display' => 'Ckeditor',
            'name' => 'body'
        ];
    }

    public function descriptionField()
    {
        return [
            'name' => 'description',
            'label' => 'Summary',
            'display' => 'Textarea'
        ];
    }

    public function imageField()
    {
        return [
            'name' => 'image',
            'label' => 'List View',
            'display' => 'InputFile'
        ];
    }

    public function imageFeaturedField()
    {
        return [
            'name' => 'image_feature',
            'label' => 'Featured View',
            'display' => 'InputFile'
        ];
    }

    public function statusField()
    {
        return [
            'name'        => 'status',
            'required'    => true,
            'options'    => array(
                'published'    => 'Published',
                'draft'        => 'Draft',
            ),
            'display'    => 'Select',
            'nullable'    => false,
            'default'    => 'published'
        ];
    }

    public function featuredField()
    {
        return [
            'name' => 'featured',
            'label' => 'Feature',
            'required' => false,
            'options' => array(
                't' => 'Yes',
                'f' => 'No',
            ),
            'display' => 'InputSlider',
            'default' => 'f'
        ];
    }

    public function authorField()
    {
        return [
            'name'        => 'author',
            'label'        => 'Author',
            'required'    => false,
            'display'    => 'InputText'
        ];
    }

    public function publication_nameField()
    {
        return [
            'name'        => 'publication_name',
            'label'        => 'Publication',
            'required'    => false,
            'display'    => 'InputText'
        ];
    }

    public function linkField()
    {
        return [
            'name'        => 'link',
            'label'        => 'URL',
            'required'    => false,
            'display'    => 'InputText'
        ];
    }

    public function date_publishedField()
    {
        return [
            'name'            => 'date_published',
            'label'            => 'Date Published',
            'required'        => false,
            'display'        => 'InputDatePicker',
            'transformIn'    => function ($data) {
                return new \MongoDate(strtotime($data));
            },
            'transformOut'    => function ($data) {
                return date('m/d/Y', $data->sec);
            },
            'default'        => function () {
                return date('m/d/Y');
            }
        ];
    }

    public function commentsField()
    {
        return [
            'name' => 'comments',
            'label' => 'Comments',
            'required' => false,
            'options' => array(
                't' => 'Yes',
                'f' => 'No',
            ),
            'display' => 'InputSlider',
            'default' => 'f'
        ];
    }

    public function pinnedField()
    {
        return [
            'name' => 'pinned',
            'label' => 'Pin',
            'required' => false,
            'options' => array(
                't' => 'Yes',
                'f' => 'No',
            ),
            'display' => 'InputSlider',
            'default' => 'f'
        ];
    }

    public function dateField()
    {
        return [
            'name'            => 'display_date',
            'required'        => true,
            'display'        => 'InputDatePicker',
            'transformIn'    => function ($data) {
                return new \MongoDate(strtotime($data));
            },
            'transformOut'    => function ($data) {
                return date('m/d/Y', $data->sec);
            },
            'default'        => function () {
                return date('m/d/Y');
            }
        ];
    }

    public function code_nameField()
    {
        return [
            'name' => 'code_name',
            'display'    => 'InputText'
        ];
    }

    public function tagsField()
    {
        return [
            'name' => 'tags',
            'label' => 'Tags',
            'required' => false,
            'transformIn' => function ($data) {
                if (is_array($data)) {
                    return $data;
                }

                return $this->field->csvToArray($data);
            },
            'display' => 'InputToTags',
            'multiple' => true,
            'options' => function () {
                return $this->db->distinct('blogs', 'tags');
            }
        ];
    }

    public function categoriesField()
    {
        return array(
            'name'        => 'categories',
            'label'        => 'Category',
            'required'    => false,
            'options'    => function () {
                return $this->db->fetchAllGrouped(
                    $this->db->collection('categories')->
                        find(['section' => 'Blog'])->
                        sort(['title' => 1]),
                    '_id',
                    'title');
            },
            'display'    => 'InputToTags',
            'controlled' => true,
            'multiple' => true,
        );
    }

    public function authorsField()
    {
        return array(
            'name'        => 'authors',
            'label'        => 'Authors',
            'required'    => false,
            'options'    => function () {
                return $this->db->fetchAllGrouped(
                    $this->db->collection('profiles')->
                        find()->
                        sort(['first_name' => 1]),
                    '_id',
                    'title');
            },
            'display'    => 'InputToTags',
            'controlled' => true,
            'multiple' => true,
        );
    }

    public function metakeywordsField()
    {
        return [
            'name' => 'metadata_keywords',
            'display'    => 'InputText'
        ];
    }

    public function metadescriptionField()
    {
        return [
            'name' => 'metadata_description',
            'display'    => 'InputText'
        ];
    }

    public function tablePartial()
    {
        $partial = <<<'HBS'
            <div class="top-container">
                {{#CollectionHeader}}{{/CollectionHeader}}
            </div>

           <div class="bottom-container">
              {{#if blogs}}
                    {{#CollectionPagination}}{{/CollectionPagination}}
                    {{#CollectionButtons}}{{/CollectionButtons}}

                    <table class="ui large table segment manager sortable">
                        <col width="45%">
                        <col width="25%">
                        <col width="15%">
                        <col width="15%">
                        <col width="10%">
                        <thead>
                               <tr>
                                  <th>Title</th>
                                  <th>Status</th>
                                  <th>Categories</th>
                                  <th>Featured</th>
                                  <th>Pinned</th>
                                  <th class="trash">Delete</th>
                               </tr>
                        </thead>
                        <tbody>
                            {{#each blogs}}
                                <tr data-id="{{dbURI}}">
                                    <td>{{title}}</td>
                                    <td>{{#Capitalize}}{{status}}{{/Capitalize}}</td>
                                    <td>{{#CategoriesCSV}}{{categories}}{{/CategoriesCSV}}</td>
                                    <td>{{#BooleanReadable}}{{featured}}{{/BooleanReadable}}</td>
                                    <td>{{#BooleanReadable}}{{pinned}}{{/BooleanReadable}}</td>
                                    <td>
                                       <div class="manager trash ui icon button"><i class="trash icon"></i></div>
                                    </td>
                                 </tr>
                            {{/each}}
                         </tbody>
                    </table>
                    {{#CollectionPagination}}{{/CollectionPagination}}
                {{else}}
                     {{#CollectionEmpty}}{{/CollectionEmpty}}
              {{/if}}
           </div>
HBS;

        return $partial;
    }

    public function formPartial()
    {
        $partial = <<<'HBS'
            {{#Form}}{{/Form}}
                <div class="top-container">
                    {{#DocumentHeader}}{{/DocumentHeader}}
                    {{#DocumentTabs}}{{/DocumentTabs}}
                </div>

                <div class="bottom-container">
                    <div class="ui tab active" data-tab="Main">
                        {{#DocumentFormLeft}}
                            {{#FieldLeft title Title required}}{{/FieldLeft}}
                            {{#FieldLeft body Body}}{{/FieldLeft}}
                            {{#FieldLeft description Summary}}{{/FieldLeft}}
                            {{{id}}}
                        {{/DocumentFormLeft}}

                        {{#DocumentFormRight}}
                            {{#DocumentButton}}{{/DocumentButton}}
                            {{#FieldFull status}}{{/FieldFull}}
                            <br />
                            {{#FieldFull display_date}}{{/FieldFull}}
                            <div class="ui clearing divider"></div>
                            {{#FieldLeft featured}}{{/FieldLeft}}
                            <br />
                            {{#FieldLeft pinned}}{{/FieldLeft}}
                            <br />
                            {{#FieldLeft comments}}{{/FieldLeft}}
                            <div class="ui clearing divider"></div>
                            {{#FieldFull categories Categories}}{{/FieldFull}}
                            {{#FieldFull authors Authors}}{{/FieldFull}}
                            {{#FieldFull tags Tags}}{{/FieldFull}}
                        {{/DocumentFormRight}}
                    </div>

                     <div class="ui tab" data-tab="Images">
                        {{#DocumentFormLeft}}
                            {{#FieldLeft image "List View"}}{{/FieldLeft}}
                            {{#FieldLeft image_feature Featured}}{{/FieldLeft}}
                        {{/DocumentFormLeft}}

                        {{#DocumentFormRight}}
                            {{#DocumentButton}}{{/DocumentButton}}
                        {{/DocumentFormRight}}
                    </div>
                    <div class="ui tab" data-tab="External Article">
                         {{#DocumentFormLeft}}
                            {{#FieldLeft author Author}}{{/FieldLeft}}
                            {{#FieldLeft publication_name Publication}}{{/FieldLeft}}
                              {{#FieldLeft link URL}}{{/FieldLeft}}
                              {{#FieldLeft date_published Date Published}}{{/FieldLeft}}
                        {{/DocumentFormLeft}}

                        {{#DocumentFormRight}}
                            {{#DocumentButton}}{{/DocumentButton}}
                        {{/DocumentFormRight}}
                    </div>
                    <div class="ui tab" data-tab="SEO">
                         {{#DocumentFormLeft}}
                            {{#FieldLeft code_name Slug}}{{/FieldLeft}}
                            {{#FieldLeft metadata_description Description}}{{/FieldLeft}}
                              {{#FieldLeft metadata_keywords Keywords}}{{/FieldLeft}}
                        {{/DocumentFormLeft}}

                        {{#DocumentFormRight}}
                            {{#DocumentButton}}{{/DocumentButton}}
                        {{/DocumentFormRight}}
                    </div>
                </div>
            </form>
HBS;

        return $partial;
    }
}
