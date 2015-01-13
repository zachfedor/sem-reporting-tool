<div id="dv-facebook-component" class="report-component">
    <h3 class="rc-title rc-full">Facebook</h3>

    <div class="rc-content">
        <div class="rc-col rc-col-one">

            <h4 class="rc-subtitle">Totals</h4>
            <h5 class="rc-heading">Total Likes</h5>
            <p class="rc-data"><?php echo $this->total_likes; ?></p>
            <hr/>
            <h5 class="rc-heading">Total Reach</h5>
            <p class="rc-data"><?php echo $this->total_reach; ?></p>
        </div>
        <div class="rc-col rc-col-two">
            <h4 class="rc-subtitle">Reach Breakdown</h4>
            <table id="tbl-facebook-reach-breakdown" class="rc-table">
                <thead>
                <tr>
                    <th class="rc-table-head">Times Seen</th>
                    <th class="rc-table-head"># People</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ( $this->reach_breakdown as $times_seen => $num_people ) { ?>
                    <tr>
                        <td class="rc-table-dark"><?php echo $times_seen; ?></td>
                        <td class="rc-table-light"><?php echo $num_people; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="rc-full">
            <h4 class="rc-subtitle">Top Ten Posts</h4>
            <table id="tbl-facebook-top-ten-posts" class="rc-table">
                <thead>
                <tr>
                    <th class="rc-table-head">Content</th>
                    <th class="rc-table-head">Engagement Rate</th>
                    <th class="rc-table-head">Reach</th>
                    <th class="rc-table-head">Created Date</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ( $this->top_ten_posts as $facebook_post ) { ?>
                    <tr>
                        <td class="rc-table-dark"><?php echo $facebook_post->get_content(); ?></td>
                        <td class="rc-table-light"><span>Engagement Rate</span><?php echo $facebook_post->get_engagement() * 100; ?>%</td>
                        <td class="rc-table-light"><span>Reach</span><?php echo $facebook_post->get_reach(); ?></td>
                        <td class="rc-table-light"><span>Created Date</span><?php echo date( 'F j, Y', strtotime( $facebook_post->get_created_time() ) ); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>