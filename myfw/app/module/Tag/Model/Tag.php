<?php
class Tag_Model_Tag extends Core_Model
{
    public static $_table = 'tag';

    public function insertTags($inputTags, $postId, &$postTagModel)
    {
        
        $tagInputs = explode(',', $inputTags);

        foreach ($tagInputs as $tagInput) {
            $slug = Base_Helper_String::generateSlug($tagInput);
            // Check tag is exists
            $tag = $this->fetch('id', 'WHERE slug = :slug LIMIT 1', array(':slug' => $slug));
            if (isset($tag->id)) {
                // Check post_tag is exists
                if (!$postTagModel->fetch('*', 'WHERE id_post = :id_post AND id_tag = :id_tag LIMIT 1',
                                         array(
                                             ':id_post' => $postId,
                                             ':id_tag' => $tag->id
                                         ))
                ) {
                    // Save post_tag
                    $postTagModel->id_post = $postId;
                    $postTagModel->id_tag  = $tag->id;
                    $postTagModel->save();
                }
            } else {
                // Save tag
                $this->name = $tagInput;
                $this->slug = Base_Helper_String::generateSlug($tagInput);
                $this->save();

                // Save post_tag
                $postTagModel->id_post = $postId;
                $postTagModel->id_tag  = $this->lastInsertId;
                $postTagModel->save();
            }
        }
    }

}