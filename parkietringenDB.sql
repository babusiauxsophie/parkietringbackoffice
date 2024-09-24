SELECT orders.*,sum(price) as total_price FROM db.orders
join order_ring on orders.order_id=order_ring.order_id
group by orders.order_id;