<?php
class ModelExtensionModuleDkSeoGenerate extends Model {
    public function getCategories()
    {
        $sql = "SELECT c.category_id as id, c.language_id, c.name FROM " . DB_PREFIX . "category_description c ORDER BY c.category_id ASC";
        $query = $this->db->query( $sql );

        return $query->rows;
    }

    public function countCategories()
    {
        $query = $this->db->query("SELECT COUNT(*) as category_total FROM " . DB_PREFIX . "category_description");
        return $query->row['category_total'];
    }

    public function countProducts()
    {
        $query = $this->db->query("SELECT COUNT(*) as product_total FROM " . DB_PREFIX . "product_description");
        return $query->row['product_total'];
    }

    public function countArticles()
    {
        $query = $this->db->query("SELECT COUNT(*) as article_total FROM " . DB_PREFIX . "information_description");
        return $query->row['article_total'];
    }

    public function updateSeoUrl($data = [])
    {
        $result = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE store_id = '" . (int)$data['store_id'] . "' AND language_id = '" . (int)$data['language_id'] . "' AND query = '". $this->db->escape($data['query']) ."=" . (int)$data['id'] . "'");
        $result_url = isset($result->row['keyword']) ? $result->row['keyword'] : '';
        $sql_for_update = "UPDATE " . DB_PREFIX . "seo_url SET keyword = '" . $this->db->escape($data['keyword']) . "' WHERE store_id = '" . (int)$data['store_id'] . "' AND language_id = '" . (int)$data['language_id'] . "' AND query = '". $this->db->escape($data['query']) ."=" . (int)$data['id'] . "'";
        $sql_for_insert = "INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$data['store_id'] . "', language_id = '" . (int)$data['language_id'] . "', query = '". $this->db->escape($data['query']) ."=" . (int)$data['id'] . "', keyword = '" . $this->db->escape($data['keyword']) . "'";

        if ($data['all'] === 'all' && $result->row) {
            $this->db->query($sql_for_update);
            $result_url = $data['keyword'];
        } else if ($data['all'] === 'all' && !$result->row) {
            $this->db->query($sql_for_insert);
            $result_url = $data['keyword'];
        } else if ($data['all'] === 'only_empty' && !$result->row) {
            $this->db->query($sql_for_insert);
            $result_url = $data['keyword'];
        }

        return $result_url;
    }

    public function getProducts()
    {
        $sql = "SELECT pd.product_id as id, pd.language_id, pd.name FROM " . DB_PREFIX . "product_description pd ORDER BY pd.product_id, pd.name ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getArticles()
    {
        $sql = "SELECT a.information_id as id, a.language_id, a.title as name FROM " . DB_PREFIX . "information_description a ORDER BY a.information_id, a.title ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }
}
